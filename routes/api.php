<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', fn(Request $request) => $request->user());

/*
|--------------------------------------------------------------------------
| 🔔 CHECK ORDER REALTIME (UNTUK ADMIN)
|--------------------------------------------------------------------------
*/
Route::get('/check-order', function () {

    $order = Order::latest()->first();

    return response()->json([
        'id' => $order?->id,
        'total' => $order?->total() ?? 0,
        'created_at' => $order?->created_at?->format('H:i:s')
    ]);
});
