<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->search($request->search)
            ->latest()
            ->paginate(10);

        return $request->wantsJson()
            ? response()->json($products)
            : view('products.index', compact('products'));
    }

    public function create(): View|Factory
    {
        return view('products.create');
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $productData = $request->validated();

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $path = $image->storeAs('products', $imageName, 'public');
            $productData['image'] = $path;

            $productData['image'] = $imageName;
        }

        Product::create($productData);

        return redirect()
            ->route('products.index')
            ->with('success', __('product.success_creating'));
    }

    public function edit(Product $product): View|Factory
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $productData = $request->validated();

        if ($request->hasFile('image')) {

            if ($product->image && file_exists(public_path('products/' . $product->image))) {

                unlink(public_path('products/' . $product->image));
            }

            $image = $request->file('image');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $path = $image->storeAs('products', $imageName, 'public');
            $productData['image'] = $path;

            $productData['image'] = $imageName;
        }

        $product->update($productData);

        return redirect()
            ->route('products.index')
            ->with('success', __('product.success_updating'));
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->image && file_exists(public_path('products/' . $product->image))) {

            unlink(public_path('products/' . $product->image));
        }

        $product->delete();

        return response()->json(['success' => true]);
    }
}
