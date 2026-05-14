<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Save a new product (Seller action)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProductRequest($request);
        $category = $this->resolveCategory($validated['category']);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'seller_id' => auth()->id(),
            'category_id' => $category->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'minimum_stock' => $validated['minimum_stock'] ?? 15,
            'discount' => $validated['discount'] ?? 0,
            'sizes' => $validated['sizes'] ?? null,
            'colors' => $validated['colors'] ?? null,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('seller.home')->with('success', 'Product listed successfully!');
    }

    /**
     * Update an existing product
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwnership($product);
        $validated = $this->validateProductRequest($request);
        $category = $this->resolveCategory($validated['category']);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $category->id,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'minimum_stock' => $validated['minimum_stock'] ?? ($product->minimum_stock ?: 15),
            'discount' => $validated['discount'] ?? $product->discount,
            'sizes' => $validated['sizes'] ?? $product->sizes,
            'colors' => $validated['colors'] ?? $product->colors,
            'image_path' => $imagePath,
            'is_active' => $request->boolean('is_active', $product->is_active),
        ]);

        return redirect()->route('seller.home')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->ensureOwnership($product);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product permanently deleted from the database.');
    }

    /**
     * Import products in bulk from an Excel file.
     */
    public function import(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt'],
        ]);

        $category = $this->resolveCategory($validated['category']);

        Excel::import(
            new ProductsImport($request->user(), $category),
            $request->file('file')
        );

        return redirect()->route('seller.home')->with('success', 'Products imported successfully!');
    }

    protected function ensureOwnership(Product $product): void
    {
        if ($product->seller_id !== auth()->id()) {
            abort(403);
        }
    }

    protected function validateProductRequest(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'sizes' => ['nullable', 'string'],
            'colors' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
    }

    protected function resolveCategory(string $categoryName): Category
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug(trim($categoryName))],
            [
                'name' => trim($categoryName),
                'is_active' => true,
            ]
        );

        if (!$category->is_active) {
            $category->update(['is_active' => true]);
        }

        return $category;
    }
}
