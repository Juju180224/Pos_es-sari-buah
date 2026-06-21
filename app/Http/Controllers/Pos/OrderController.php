<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST ORDERS
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View {

        $orders = Order::query()

            ->with([
                'items.product',
                'payments',
                'customer'
            ])

            ->when(
                $request->input('start_date'),
                function ($query, $startDate): void {

                    $query->where(
                        'created_at',
                        '>=',
                        $startDate
                    );
                }
            )

            ->when(
                $request->input('end_date'),
                function ($query, string $endDate): void {

                    $query->where(
                        'created_at',
                        '<=',
                        $endDate . ' 23:59:59'
                    );
                }
            )

            ->latest()

            ->paginate(10);

        $total = $orders->sum(
            fn($order) => $order->total()
        );

        $receivedAmount = $orders->sum(
            fn($order) => $order->receivedAmount()
        );

        return view('orders.index', [

            'orders' => $orders,

            'total' => $total,

            'receivedAmount' => $receivedAmount

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE ORDER
    |--------------------------------------------------------------------------
    */

    public function store(
        OrderStoreRequest $request
    ): \Illuminate\Http\JsonResponse {

        try {

            $authUser = $request->user();

            $cartItems = $authUser
                ->cart()
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => __('cart.empty'),
                ], 400);
            }

            $order = DB::transaction(function () use (
                $request,
                $authUser,
                $cartItems
            ) {

                /*
                |--------------------------------------------------------------------------
                | CREATE ORDER
                |--------------------------------------------------------------------------
                */

                $order = Order::create([

                    'customer_id' => $request->customer_id,

                    'user_id' => $authUser->id,

                    'status' => 'pending'
                ]);

                /*
                |--------------------------------------------------------------------------
                | SAVE ORDER ITEMS
                |--------------------------------------------------------------------------
                */

                foreach ($cartItems as $item) {

                    $this->createOrderItem(
                        $order,
                        $item
                    );

                    $this->reduceProductStock(
                        $item
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | CLEAR CART
                |--------------------------------------------------------------------------
                */

                $authUser
                    ->cart()
                    ->detach();

                /*
                |--------------------------------------------------------------------------
                | CREATE PAYMENT
                |--------------------------------------------------------------------------
                */

                $order->payments()->create([

                    'amount' => $request->amount,

                    'user_id' => $authUser->id,
                ]);

                return $order;
            });

            return response()->json([

                'success' => true,

                'message' => __('order.created_successfully'),

                'order_id' => $order->id,

            ], 201);
        } catch (\Throwable $e) {

            return response()->json([

                'success' => false,

                'message' => $e->getMessage(),

            ], 400);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PARTIAL PAYMENT
    |--------------------------------------------------------------------------
    */

    public function partialPayment(
        Request $request
    ) {

        $request->validate([
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'in:cash,qris,transfer_bca,transfer_bni,transfer_mandiri,transfer_bri,ovo,gopay,dana'],
        ]);

        $order = Order::findOrFail(
            $request->input('order_id')
        );

        $remainingAmount =
            $order->total()
            - $order->receivedAmount();

        if (
            $request->input('amount')
            > $remainingAmount
        ) {

            return redirect()

                ->route('orders.index')

                ->withErrors(
                    __('order.amount_exceeds_balance')
                );
        }

        DB::transaction(function () use (
            $order,
            $request
        ): void {

            $order->payments()->create([

                'amount' => $request->amount,

                'payment_method' => $request->payment_method,

                'user_id' => Auth::id()
            ]);
        });

        return redirect()

            ->route('orders.index')

            ->with(
                'success',
                __('order.partial_payment_success', [

                    'amount' =>
                    config('settings.currency_symbol')
                        . \number_format(
                            $request->amount,
                            2
                        )
                ])
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER ITEM
    |--------------------------------------------------------------------------
    */

    private function createOrderItem(
        Order $order,
        Product $item
    ): void {

        $order->items()->create([

            'product_id' => $item->id,

            'quantity' => $item->pivot->quantity,

            'price' => $item->price,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REDUCE STOCK
    |--------------------------------------------------------------------------
    */

    private function reduceProductStock(
        Product $item
    ): void {

        $item->decrement(

            'quantity',

            $item->pivot->quantity
        );
    }
}
