<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of raw materials.
     */
    public function index(Request $request): View
    {
        $rawMaterials = RawMaterial::query()
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('raw-materials.index', ['rawMaterials' => $rawMaterials]);
    }

    /**
     * Show the form for creating a new raw material.
     */
    public function create(): View
    {
        return view('raw-materials.create');
    }

    /**
     * Store a newly created raw material.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'low_stock_threshold' => ['nullable', 'numeric', 'min:0'],
        ]);

        RawMaterial::create($request->all());

        return redirect()->route('raw-materials.index')
            ->with('success', __('Bahan baku berhasil ditambahkan!'));
    }

    /**
     * Show the form for editing the specified raw material.
     */
    public function edit(RawMaterial $rawMaterial): View
    {
        return view('raw-materials.edit', ['rawMaterial' => $rawMaterial]);
    }

    /**
     * Update the specified raw material.
     */
    public function update(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'stock' => ['required', 'numeric', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'low_stock_threshold' => ['nullable', 'numeric', 'min:0'],
        ]);

        $rawMaterial->update($request->all());

        return redirect()->route('raw-materials.index')
            ->with('success', __('Bahan baku berhasil diperbarui!'));
    }

    /**
     * Remove the specified raw material.
     */
    public function destroy(RawMaterial $rawMaterial): RedirectResponse
    {
        $rawMaterial->delete();

        return redirect()->route('raw-materials.index')
            ->with('success', __('Bahan baku berhasil dihapus!'));
    }
}
