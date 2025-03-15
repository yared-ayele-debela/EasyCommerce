<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\Stock\Stock;
use App\Models\AppSetting;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\WarehouseManager;
use App\Models\WereHouses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StockController extends Controller
{

    public function live_wire(){

        return view('admin.stocks.index')->withComponent(Stock::class);
    }
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view stock')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $all_stock = ProductAttribute::with('product', 'warehouse')->get();
            return view('admin.stocks.index', compact('all_stock', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add stock')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $products = Product::where('status', 1)->get();
            $user_id=Auth::guard('admin')->user()->id;
            $warehouse_manager=WarehouseManager::where('manager_id',$user_id)->first();
            if($warehouse_manager){
                $warehouses=WereHouses::where('id',$warehouse_manager->warehouse_id)->get();
            }else{
                $warehouses = WereHouses::where('status', 1)->get();
            }
            return view('admin.stocks.create', compact('products', 'warehouses', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add stock')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $selectedProducts = $request->input('selectedProducts');
            if (is_array($selectedProducts)) {
                $selectedProducts = implode(',', $selectedProducts); // Convert array to comma-separated string
            }
            $selectedProductsArray = explode(',', $selectedProducts);

            foreach ($selectedProductsArray as $product) {
                $warehouse = $request->input('warehouse_' . $product);
                $discount = $request->input('size_' . $product);
                $quantity = $request->input('price_' . $product);
                $price = $request->input('stock_' . $product);
                $sku = $request->input('sku_' . $product);

                // Validate inputs here if required
                // Example: You can add validation rules for warehouse, discount, quantity, price, and sku

                $productStock = new ProductAttribute();
                $productStock->product_id = $product;
                $productStock->warehouse_id = $warehouse;
                $productStock->size = $discount;
                $productStock->sku = $sku;
                $productStock->stock = $quantity;
                $productStock->price = $price;
                $productStock->save();
            }

            Alert::toast('Products have been added successfully!', 'success');
            return redirect()->route('stocks.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}