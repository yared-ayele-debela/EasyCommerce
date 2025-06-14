<?php

namespace App\Http\Controllers\Restaurant\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\ProductSize;
use App\Models\Restaurant\Restaurant;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductSizeController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('admin.permission:view_restaurant_product')->only('index');
        $this->middleware('admin.permission:add_restaurant_product')->only('store');
        $this->middleware('admin.permission:edit_restaurant_product')->only(methods: 'update');
        $this->middleware('admin.permission:delete_restaurant_product')->only('destroy');
    }
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

             $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Restaurant Product Size', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

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

         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Restaurant Product Size', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->back()->with('success', 'Product size updated successfully.');
    }

    public function destroy($productId, $sizeId)
    {
        $product = Product::findOrFail($productId);
        $productSize = ProductSize::findOrFail($sizeId);

        $productSize->delete();

         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log(  'Delete Restaurant Product Size', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return redirect()->route('products.show', $productId)->with('success', 'Product size deleted successfully.');
    }
}