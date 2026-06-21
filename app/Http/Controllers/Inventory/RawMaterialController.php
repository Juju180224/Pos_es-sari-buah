<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of raw materials.
     */
    public function index(Request $request): View
    {
        $rawMaterials = RawMaterial::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('raw-materials.index', compact('rawMaterials'));
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
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'unit'                => 'required|string|max:50',
            'stock'               => 'required|numeric|min:0',
            'purchase_price'      => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|numeric|min:0',
        ]);

        RawMaterial::create($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial): View
    {
        return view('raw-materials.show', compact('rawMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial): View
    {
        return view('raw-materials.edit', compact('rawMaterial'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, RawMaterial $rawMaterial): RedirectResponse
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'unit'                => 'required|string|max:50',
            'stock'               => 'required|numeric|min:0',
            'purchase_price'      => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|numeric|min:0',
        ]);

        $rawMaterial->update($validated);

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(RawMaterial $rawMaterial): RedirectResponse
    {
        $rawMaterial->delete();

        return redirect()
            ->route('raw-materials.index')
            ->with('success', 'Bahan baku berhasil dihapus.');
    }
}