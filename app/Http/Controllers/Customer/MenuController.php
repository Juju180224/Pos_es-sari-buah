<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customers.menu', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Session::get('cart', []);

        $product = Product::query()->findOrFail(
            $request->input('product_id')
        );

        if (isset($cart[$product->id_produk])) {

            $cart[$product->id_produk]['qty']++;
        } else {

            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'qty'   => 1
            ];
        }

        Session::put('cart', $cart);

        return Response::json([
            'success'    => true,
            'message'    => 'Produk ditambahkan',
            'cart_count' => count($cart)
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cart = Session::get('cart', []);

        $productId = $request->input('product_id');

        if (isset($cart[$productId])) {

            if ($cart[$productId]['qty'] > 1) {

                $cart[$productId]['qty']--;
            } else {

                unset($cart[$productId]);
            }
        }

        Session::put('cart', $cart);

        return Response::json([
            'success' => true
        ]);
    }

    public function getCart()
    {
        $cart = Session::get('cart', []);

        $total = 0;

        foreach ($cart as $item) {

            $total += $item['price'] * $item['qty'];
        }

        return Response::json([
            'items' => $cart,
            'total' => $total
        ]);
    }

    public function checkout(Request $request)
    {
        $quantities = $request->input('qty', []);

        $items = [];
        foreach ($quantities as $productId => $qty) {
            $qty = (int) $qty;
            if ($qty <= 0) {
                continue;
            }

            $product = Product::find($productId);
            if (!$product) {
                continue;
            }

            $items[] = [
                'product' => $product,
                'qty'     => $qty,
            ];
        }

        if (empty($items)) {
            return Redirect::back()->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_id' => null,
                'user_id'     => null,
                'status'      => 'pending',
            ]);

            foreach ($items as $item) {
                $product = $item['product'];
                $qty = $item['qty'];

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'price'      => $product->price,
                    'quantity'   => $qty,
                ]);

                $product->decrement('quantity', $qty);
            }

            DB::commit();

            Session::forget('cart');

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dikirim');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}
