<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    //
    public function store(Request $request, $productId)
    {
        $request->validate([
            'size' => 'required|in:small,medium,large',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        
        $product = Product::findOrFail($productId);

        // // Check if the size already exists for the product
        // $existingSize = ProductSize::where('product_id', $productId)
        // ->where('size', $request->size)
        // ->first();

        // if ($existingSize) {
        //     return redirect()->route('products.show', $productId)
        //         ->with('error', 'This size is already added for this product.');
        // }

        // Create the product size
        $productSize = new ProductSize();
        $productSize->product_id = $product->id;
        $productSize->size = $request->size;
        $productSize->price = $request->price;
        $productSize->stock = $request->stock;
        $productSize->save();

        return redirect()->route('products.show', $productId)->with('success', 'Product size created successfully.');
    }

    public function update(Request $request, $sizeId)
    {
        $request->validate([
            'size' => 'required|in:small,medium,large',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $productSize = ProductSize::findOrFail($sizeId);
      
        $productSize->size = $request->size;
        $productSize->price = $request->price;
        $productSize->stock = $request->stock;
        $productSize->save();

        return redirect()->back()->with('success', 'Product size updated successfully.');
    }

    public function destroy($productId, $sizeId)
    {
        $product = Product::findOrFail($productId);
        $productSize = ProductSize::findOrFail($sizeId);

        $productSize->delete();

        return redirect()->route('products.show', $productId)->with('success', 'Product size deleted successfully.');
    }
}