<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseStoreRequest;
use App\Http\Requests\Purchase\PurchaseUpdateRequest;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    /**
     * Display a listing of purchases with filters
     */
    public function index(Request $request): View
    {
        $purchases = Purchase::with(['supplier', 'user', 'items'])
            ->filter($request->only(['status', 'supplier_id', 'date_from', 'date_to', 'search']))
            ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('sort_order', 'desc'))
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::orderBy('first_name')->get();

        return view('purchases.index', ['purchases' => $purchases, 'suppliers' => $suppliers]);
    }

    /**
     * Get purchases data as JSON for AJAX filtering, plus ringkasan
     * pengeluaran (pembelian bahan baku) vs pemasukan (penjualan).
     */
    public function data(Request $request): JsonResponse
    {
        try {
            $purchases = Purchase::with(['supplier', 'user'])
                ->withCount('items')
                ->filter($request->only(['status', 'supplier_id', 'date_from', 'date_to', 'search']))
                ->orderBy($request->get('sort_by', 'purchase_date'), $request->get('sort_order', 'desc'))
                ->paginate(10);

            // --- Ringkasan Pengeluaran (pembelian bahan baku) ---
            $expenseQuery = Purchase::query()->where('status', 'completed');

            if ($request->filled('date_from')) {
                $expenseQuery->where('purchase_date', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $expenseQuery->where('purchase_date', '<=', $request->date_to);
            }

            $totalExpense = (float) $expenseQuery->sum('total_amount');

            // --- Ringkasan Pemasukan (penjualan / orders) ---
            $incomeQuery = Order::query();

            if ($request->filled('date_from')) {
                $incomeQuery->where('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $incomeQuery->where('created_at', '<=', $request->date_to . ' 23:59:59');
            }

            $totalIncome = (float) $incomeQuery->get()->sum(
                fn ($order) => $order->receivedAmount()
            );

            $response = $purchases->toArray();
            $response['summary'] = [
                'total_expense' => $totalExpense,
                'total_income' => $totalIncome,
                'net' => $totalIncome - $totalExpense,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new purchase
     */
    public function create(): View
    {
        $suppliers = Supplier::all();

        return view('purchases.create', ['suppliers' => $suppliers]);
    }

    /**
     * Store a newly created purchase
     */
    public function store(PurchaseStoreRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
                'status' => $request->status ?? 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'raw_material_id' => $item['raw_material_id'],
                    'quantity' => $item['quantity'],
                    'purchase_price' => $item['purchase_price'],
                ]);

                // Jika status completed, update stok & harga beli bahan baku
                if ($request->status === 'completed') {
                    $rawMaterial = RawMaterial::find($item['raw_material_id']);

                    if ($rawMaterial) {
                        $rawMaterial->stock += $item['quantity'];
                        $rawMaterial->purchase_price = $item['purchase_price'];
                        $rawMaterial->save();
                    }
                }
            }

            DB::commit();

            $request->user()->purchaseCart()->detach();

            return redirect()->route('purchases.index')
                ->with('success', __('Purchase created successfully!'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Failed to create purchase: ') . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified purchase
     */
    public function show(Purchase $purchase): View
    {
        $purchase->load(['supplier', 'user', 'items.rawMaterial']);

        return view('purchases.show', ['purchase' => $purchase]);
    }

    /**
     * Update the specified purchase
     */
    public function update(PurchaseUpdateRequest $request, Purchase $purchase): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $oldStatus = $purchase->status;
            $newStatus = $request->status;

            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
                'status' => $newStatus,
                'notes' => $request->notes,
            ]);

            if ($oldStatus !== $newStatus) {
                foreach ($purchase->items as $item) {
                    $rawMaterial = $item->rawMaterial;

                    if (!$rawMaterial) {
                        continue;
                    }

                    if ($oldStatus === 'completed' && in_array($newStatus, ['pending', 'cancelled'])) {
                        $rawMaterial->stock -= $item->quantity;
                        $rawMaterial->save();
                    }

                    if (in_array($oldStatus, ['pending', 'cancelled']) && $newStatus === 'completed') {
                        $rawMaterial->stock += $item->quantity;
                        $rawMaterial->purchase_price = $item->purchase_price;
                        $rawMaterial->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', __('Purchase updated successfully!'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Failed to update purchase: ') . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified purchase
     */
    public function destroy(Purchase $purchase): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if ($purchase->status === 'completed') {
                foreach ($purchase->items as $item) {
                    $rawMaterial = $item->rawMaterial;

                    if ($rawMaterial) {
                        $rawMaterial->stock -= $item->quantity;
                        $rawMaterial->save();
                    }
                }
            }

            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', __('Purchase deleted successfully!'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Failed to delete purchase: ') . $e->getMessage());
        }
    }

    /**
     * Generate 80mm thermal receipt PDF
     */
    public function receipt(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.rawMaterial']);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('purchases.receipt', ['purchase' => $purchase]);
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait');

        return $pdf->stream("purchase-receipt-{$purchase->id}.pdf");
    }
}