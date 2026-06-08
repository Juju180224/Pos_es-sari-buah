<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\PurchaseCartController;
use App\Http\Controllers\Inventory\PurchaseController;
use App\Http\Controllers\Management\CustomerController;
use App\Http\Controllers\Management\SupplierController;
use App\Http\Controllers\Pos\CartController;
use App\Http\Controllers\Pos\OrderController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\SmartController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| PUBLIC MENU (QR MENU)
|--------------------------------------------------------------------------
*/

Route::prefix('menu')->group(function () {

    Route::get('/', [MenuController::class, 'index'])->name('menu');

    Route::post('/cart/add', [MenuController::class, 'addToCart']);
    Route::post('/cart/remove', [MenuController::class, 'removeFromCart']);

    Route::get('/cart', [MenuController::class, 'getCart']);

    Route::post('/checkout', [MenuController::class, 'checkout'])
        ->name('menu.checkout');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'locale'])
    ->group(function () {

        /*
        | DASHBOARD
        */
        Route::get('/', HomeController::class)->name('home');

        /*
        | SETTINGS
        */
        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('/settings', [SettingController::class, 'store'])
            ->name('settings.store');

        /*
        | MASTER DATA
        */
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('suppliers', SupplierController::class);

        /*
        | ORDER LATEST (SIMPLIFIED)
        */
        Route::get('/orders/latest', function () {
            return \App\Models\Order::with('items.product')
                ->latest()
                ->take(5)
                ->get();
        });

        /*
        | POS CART
        */
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
        Route::delete('/cart/delete', [CartController::class, 'delete']);
        Route::delete('/cart/empty', [CartController::class, 'empty']);

        /*
        | PURCHASE
        */
        Route::resource('purchases', PurchaseController::class);

        Route::get('/purchases/data', [PurchaseController::class, 'data'])
            ->name('purchases.data');

        Route::get('/purchases/{purchase}/receipt', [PurchaseController::class, 'receipt'])
            ->name('purchases.receipt');

        /*
        | PURCHASE CART
        */
        Route::prefix('purchase-cart')
            ->name('purchase-cart.')
            ->group(function () {

                Route::get('/', [PurchaseCartController::class, 'index'])->name('index');
                Route::post('/', [PurchaseCartController::class, 'store'])->name('store');
                Route::post('/change-qty', [PurchaseCartController::class, 'changeQty'])->name('change-qty');
                Route::post('/change-price', [PurchaseCartController::class, 'changePrice'])->name('change-price');
                Route::delete('/delete', [PurchaseCartController::class, 'delete'])->name('delete');
                Route::delete('/empty', [PurchaseCartController::class, 'empty'])->name('empty');
            });

        /*
        | EXTRA ORDER PAYMENT
        */
        Route::post('/orders/partial-payment', [OrderController::class, 'partialPayment'])
            ->name('orders.partial-payment');

        /*
        | TRANSLATION
        */
        Route::get('/locale/{type}', function ($type) {
            return response()->json(trans($type));
        });

        /*
        | LANGUAGE SWITCH
        */
        Route::get('/lang-switch/{lang}', function ($lang) {

            if (in_array($lang, ['en', 'id'])) {
                session(['locale' => $lang]);
                app()->setLocale($lang);
            }

            return redirect()->back();
        })->name('lang.switch');

        /*
        | SMART MODULE
        */
        Route::prefix('smart')->name('smart.')->group(function () {

            Route::get('/kriteria', [SmartController::class, 'kriteria'])->name('kriteria');
            Route::get('/alternatif', [SmartController::class, 'alternatif'])->name('alternatif');
            Route::get('/penilaian', [SmartController::class, 'penilaian'])->name('penilaian');
            Route::get('/proses', [SmartController::class, 'proses'])->name('proses');
            Route::get('/hasil', [SmartController::class, 'hasil'])->name('hasil');
        });
    });
