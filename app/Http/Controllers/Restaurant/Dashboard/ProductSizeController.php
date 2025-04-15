<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\ProductSize;
use App\Models\Restaurant\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Find the product by ID
        
        $restaurants=Restaurant::where('admin_id',Auth::guard('admin')->user()->id)->get();
        $restaurantId= $restaurants->pluck('id');
        
        $product = Product::whereIn('restaurant_id',$restaurantId)->findOrFail($productId);
        if($product){
        
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
        }
        else{
            return redirect()->back()->with('error', 'Product not found.');
        }

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