<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\AddToPurchaseCartRequest;
use App\Http\Requests\Purchase\ChangePurchaseCartQtyRequest;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseCartController extends Controller
{
    /**
     * Get purchase cart items
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $cart = $user->purchaseCart()->get();

        $formattedCart = $cart->map(function ($item): array {
            assert($item instanceof RawMaterial);

            return [
                'id' => $item->id,
                'name' => $item->name,
                'unit' => $item->unit,
                'pivot' => [
                    'quantity' => $item->pivot->quantity,
                    'purchase_price' => $item->pivot->purchase_price,
                    'raw_material_id' => $item->id,
                    'user_id' => $item->pivot->user_id,
                ],
            ];
        })->values();

        return response()->json($formattedCart);
    }

    /**
     * Add raw material to purchase cart
     */
    public function store(AddToPurchaseCartRequest $request): JsonResponse
    {
        $rawMaterial = RawMaterial::find($request->input('raw_material_id'));

        if (!$rawMaterial) {
            return response()->json([
                'message' => __('Raw material not found!')
            ], 404);
        }

        /** @var User $user */
        $user = Auth::user();

        $cartItem = $user->purchaseCart()
            ->where('raw_material_id', $rawMaterial->id)
            ->first();

        if ($cartItem !== null) {
            $currentQuantity = (int) $cartItem->pivot->quantity;
            $user->purchaseCart()->updateExistingPivot($rawMaterial->id, [
                'quantity' => $currentQuantity + 1,
            ]);
        } else {
            $user->purchaseCart()->attach($rawMaterial->id, [
                'quantity' => 1,
                'purchase_price' => $rawMaterial->purchase_price ?? 0
            ]);
        }

        return response()->json([
            'message' => __('Raw material added to cart!')
        ]);
    }

    /**
     * Change quantity in purchase cart
     */
    public function changeQty(ChangePurchaseCartQtyRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->purchaseCart()->updateExistingPivot($request->raw_material_id, [
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'message' => __('Quantity updated!')
        ]);
    }

    /**
     * Change purchase price in cart
     */
    public function changePrice(Request $request): JsonResponse
    {
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'purchase_price' => 'required|numeric|min:0',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->purchaseCart()->updateExistingPivot($request->raw_material_id, [
            'purchase_price' => $request->purchase_price,
        ]);

        return response()->json([
            'message' => __('Purchase price updated!')
        ]);
    }

    /**
     * Remove raw material from purchase cart
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->purchaseCart()->detach($request->raw_material_id);

        return response()->json([
            'message' => __('Raw material removed from cart!')
        ]);
    }

    /**
     * Empty purchase cart
     */
    public function empty(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->purchaseCart()->detach();

        return response()->json([
            'message' => __('Cart emptied!')
        ]);
    }
}