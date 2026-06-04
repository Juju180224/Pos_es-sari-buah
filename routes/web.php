<?php

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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn(): Redirector|RedirectResponse => redirect('/admin'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| 🔥 QR MENU (PUBLIC - TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::prefix('menu')->group(function () {

    // halaman menu QR
    Route::get('/', [MenuController::class, 'index'])->name('menu');

    // CART realtime (ajax)
    Route::post('/cart/add', [MenuController::class, 'addToCart']);
    Route::post('/cart/remove', [MenuController::class, 'removeFromCart']);
    Route::get('/cart', [MenuController::class, 'getCart']);

    // CHECKOUT → masuk ke admin (orders)
    Route::post('/checkout', [MenuController::class, 'checkout'])->name('menu.checkout');
});


/*
|--------------------------------------------------------------------------
| 🔐 ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'locale'])->group(function (): void {

    Route::get('/', HomeController::class)->name('home');

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('suppliers', SupplierController::class);

    /*
    |--------------------------------------------------------------------------
    | 🔔 REALTIME NOTIFICATION (ORDER BARU)
    |--------------------------------------------------------------------------
    */
    Route::get('/orders/latest', function () {
        return \App\Models\Order::with('items.product')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'total' => $order->total(),
                    'status' => $order->status,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'name' => $item->product->name,
                            'qty' => $item->quantity
                        ];
                    })
                ];
            });
    })->name('orders.latest');

    /*
    |--------------------------------------------------------------------------
    | POS CART (KASIR)
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);

    /*
    |--------------------------------------------------------------------------
    | PURCHASE
    |--------------------------------------------------------------------------
    */
    Route::get('/purchases/data', [PurchaseController::class, 'data'])->name('purchases.data');
    Route::get('/purchases/{purchase}/receipt', [PurchaseController::class, 'receipt'])->name('purchases.receipt');
    Route::resource('purchases', PurchaseController::class);

    /*
    |--------------------------------------------------------------------------
    | PURCHASE CART
    |--------------------------------------------------------------------------
    */
    Route::prefix('purchase-cart')->name('purchase-cart.')->group(function (): void {
        Route::get('/', [PurchaseCartController::class, 'index'])->name('index');
        Route::post('/', [PurchaseCartController::class, 'store'])->name('store');
        Route::post('/change-qty', [PurchaseCartController::class, 'changeQty'])->name('change-qty');
        Route::post('/change-price', [PurchaseCartController::class, 'changePrice'])->name('change-price');
        Route::delete('/delete', [PurchaseCartController::class, 'delete'])->name('delete');
        Route::delete('/empty', [PurchaseCartController::class, 'empty'])->name('empty');
    });

    /*
    |--------------------------------------------------------------------------
    | ORDERS EXTRA
    |--------------------------------------------------------------------------
    */
    Route::post('/orders/partial-payment', [OrderController::class, 'partialPayment'])
        ->name('orders.partial-payment');

    /*
    |--------------------------------------------------------------------------
    | TRANSLATION
    |--------------------------------------------------------------------------
    */
    Route::get('/locale/{type}', function ($type) {
        return response()->json(trans($type));
    });

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE SWITCH
    |--------------------------------------------------------------------------
    */
    Route::get('/lang-switch/{lang}', function ($lang) {
        $supportedLocales = ['en', 'id'];

        if (in_array($lang, $supportedLocales)) {
            session(['locale' => $lang]);
            app()->setLocale($lang);
        }

        return redirect()->back();
    })->name('lang.switch');
});