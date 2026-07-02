<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\PurchaseCartController;
use App\Http\Controllers\Inventory\PurchaseController;
use App\Http\Controllers\Inventory\RawMaterialController;
use App\Http\Controllers\Management\CustomerController;
use App\Http\Controllers\Management\SupplierController;
use App\Http\Controllers\Pos\CartController;
use App\Http\Controllers\Pos\OrderController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\SmartController;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| ROOT & LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/home', [PagesController::class, 'home'])->name('home');

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/

Route::view('/about', 'pages.about')->name('about');
Route::view('/shop', 'pages.shop')->name('shop');
Route::view('/contact', 'pages.contact')->name('contact');

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

    Route::get('/clear-cart', [MenuController::class, 'clearCart']);
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
        Route::get('/', HomeController::class)->name('admin.home');

        /*
        | SETTINGS
        */
        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('/settings', [SettingController::class, 'store'])
            ->name('settings.store');

        /*
        | ORDER RECEIPT (harus didaftarkan SEBELUM Route::resource('orders', ...)
        | agar tidak konflik dengan pattern /orders/{order})
        */
        Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt'])
            ->name('orders.receipt');

        /*
        | MASTER DATA
        */
        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('raw-materials', RawMaterialController::class);

        /*
        | ORDER LATEST
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
        Route::get('/purchases/data', [PurchaseController::class, 'data'])
            ->name('purchases.data');

        Route::get('/purchases/{purchase}/receipt', [PurchaseController::class, 'receipt'])
            ->name('purchases.receipt');

        Route::resource('purchases', PurchaseController::class);

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
        | EXTRA PAYMENT
        */
        Route::post('/orders/partial-payment', [OrderController::class, 'partialPayment'])
            ->name('orders.partial-payment');

        /*
        | TRANSLATION
        */
        Route::get('/locale/{type}', function () {
            return response()->json(trans(request()->type));
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

    // KRITERIA
    Route::get('/kriteria', [SmartController::class, 'kriteria'])->name('kriteria');
    Route::post('/kriteria', [SmartController::class, 'storeKriteria'])->name('kriteria.store');
    Route::put('/kriteria/{id}', [SmartController::class, 'updateKriteria'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [SmartController::class, 'destroyKriteria'])->name('kriteria.destroy');

    // ALTERNATIF
    Route::get('/alternatif', [SmartController::class, 'alternatif'])->name('alternatif');
    Route::post('/alternatif', [SmartController::class, 'storeAlternatif'])->name('alternatif.store');
    Route::put('/alternatif/{id}', [SmartController::class, 'updateAlternatif'])->name('alternatif.update');
    Route::delete('/alternatif/{id}', [SmartController::class, 'destroyAlternatif'])->name('alternatif.destroy');

    // PENILAIAN
    Route::get('/penilaian', [SmartController::class, 'penilaian'])->name('penilaian');
    Route::post('/penilaian', [SmartController::class, 'storePenilaian'])->name('penilaian.store');

    // PROSES & HASIL
    Route::get('/proses', [SmartController::class, 'proses'])->name('proses');
    Route::get('/hasil', [SmartController::class, 'hasil'])->name('hasil');
});
    });