<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AssignStockProduct;
use App\Models\DeliveryMan;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Transfer_stock_product;
use App\Models\TransferRequest;
use App\Models\WarehouseManager;
use App\Models\WereHouses;
use BaconQrCode\Renderer\Image\TransformationMatrix;
use Dompdf\Dompdf;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProductTransferController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view transfer product')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $all_product_stocks = Transfer_stock_product::with('product', 'fromWarehouse', 'toWarehouse')->paginate(10);

            $user_id=Auth::guard('admin')->user()->id;
            $warehouse_manager=WarehouseManager::where('manager_id',$user_id)->first();
            if($warehouse_manager){
                $all_product_stocks = Transfer_stock_product::with('product', 'fromWarehouse', 'toWarehouse')->where('from_warehouse_id',$warehouse_manager->warehouse_id)->orWhere('to_warehouse_id',$warehouse_manager->warehouse_id)->paginate(10);
            }else{
                $all_product_stocks = Transfer_stock_product::with('product', 'fromWarehouse', 'toWarehouse')->paginate(10);
            }

            // dd($all_product_stocks);
            return view('admin.transfer_stocks.index', compact('all_product_stocks', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function invoicefortransfer($id)
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view transfer product invoice')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $all_product_stocks = Transfer_stock_product::with('product', 'fromWarehouse', 'toWarehouse')->where('id', $id)->first();

            return view('admin.transfer_stocks.invoice_for_transfer_stocks.view_invoice', compact('all_product_stocks', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function good_receiving_note_invoice($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view transfer product invoice')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $stock_products = AssignStockProduct::with('transfer_stock_product', 'deliveryMan')->where('id', $id)->first();
            //    dd($stock_products);
            return view('admin.transfer_stocks.invoice_for_delivery_boy.grn_invoice', compact('appsettings', 'stock_products'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function invoice($id)
    {
        try {
            $stock_products = AssignStockProduct::with('transfer_stock_product')->where('id', $id)->first();
            $appsettings = AppSetting::all()->toArray();
            $html = view('admin.transfer_stocks.invoice', compact('stock_products', 'appsettings'))->render();

            // Create a new Dompdf instance
            $dompdf = new Dompdf();

            $dompdf->loadHtml($html);

            $dompdf->setPaper('A4', 'portrait');

            $dompdf->render();

            return $dompdf->stream('stock_transfer.pdf');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function viewinvoice($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view transfer product invoice')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();

            $stock_products = AssignStockProduct::with('transfer_stock_product', 'deliveryMan')->where('id', $id)->first();

            if ($stock_products) {
                return view('admin.transfer_stocks.invoice_for_delivery_boy.view_invoice', compact('stock_products', 'appsettings', 'id'));
            } else {
                return back()->with('error', 'Invalid Request');
            }
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add transfer product')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();

            $user_id=Auth::guard('admin')->user()->id;
            $warehouse_manager=WarehouseManager::where('manager_id',$user_id)->first();
            if($warehouse_manager){
                $fromwarehouses=WereHouses::where('id',$warehouse_manager->warehouse_id)->get();
            }
            else
            {
                $fromwarehouses = WereHouses::all()->where('status', 1);
            }

            $warehouses = WereHouses::all()->where('status', 1);
            // dd($warehouses);
            $products = Product::all()->where('status', 1);

            return view('admin.transfer_stocks.transfer_stock', compact('fromwarehouses','warehouses', 'products', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function transfer_stock(Request $request)
    {

        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add transfer product')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $validatedData = $request->validate([
                'selectedProducts.*' => 'required|exists:products,id',
                'from_warehouse_id' => 'required|exists:were_houses,id',
                'to_warehouse_id' => 'required|exists:were_houses,id',
                'stock*' => 'required',
                'transfer_date' => 'required|date',
                'note' => 'nullable',
            ]);

            $shipped_confirmation_number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $delivered_confirmation_number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            // dd($delivered_confirmation_number);

            // dd($validatedData['to_warehouse_id']);
            $fromWarehouse = $request->input('from_warehouse_id');
            $toWatehouse = $request->input('to_warehouse_id');
            $destination_warehouse=WereHouses::findOrFail($request->input('to_warehouse_id'))->first();
            // dd($destination_warehouse);

            if ($fromWarehouse == $toWatehouse) {
                // dd($fromWarehouse);
                Alert::toast('destination warehouse and from warehouse is the same!');
                return redirect()->back();
            }


            $selectedProducts = $request->input('selectedProducts');
            if (is_array($selectedProducts)) {
                $selectedProducts = implode(',', $selectedProducts); // Convert array to comma-separated string
            }
            $selectedProductsArray = explode(',', $selectedProducts);

            // dd($selectedProductsArray);
            foreach ($selectedProductsArray as $productId) {

                $stockQuantity = $request->input("stock_$productId");
                $size = $request->input("size_$productId");
                $price = $request->input("price_$productId");
                // Fetch the source warehouse stock
                $fromWarehouseStock = ProductAttribute::where('product_id', $productId)
                    ->where('warehouse_id', $validatedData['from_warehouse_id'])
                    ->where('size', $size)
                    ->first();

                if (!$fromWarehouseStock) {
                    Alert::toast('Product is not found in this warehouse', 'error');
                    return redirect()->back();
                }

                $destinationStockProduct = ProductAttribute::firstOrNew([
                    'product_id' => $productId,
                    'warehouse_id' => $request->input('to_warehouse_id'),
                    'size' => $size,
                    'price' => $price,
                    'status' => 1
                ]);
                // dd($destinationStockProduct);
                if ($fromWarehouseStock && $fromWarehouseStock->stock >= $stockQuantity) {
                    // Update source warehouse stock
                    // $fromWarehouseStock->update([
                    //     'stock' => $fromWarehouseStock->stock - $stockQuantity
                    // ]);

                    // // Update destination warehouse stock
                    // if ($destinationStockProduct) {


                    //     $destinationStockProduct->stock += $stockQuantity;
                    //     $destinationStockProduct->save();
                    // }


                    // $stock = new Transfer_stock_product();
                    // $stock->from_warehouse_id = $validatedData['from_warehouse_id'];
                    // $stock->to_warehouse_id = $validatedData['to_warehouse_id'];
                    // $stock->quantity = $stockQuantity;
                    // $stock->product_id = $productId;
                    // $stock->notes = $validatedData['note'];
                    // $stock->transfer_date = $validatedData['transfer_date'];
                    // $stock->shipped_confirmation_number = $shipped_confirmation_number;
                    // $stock->delivered_confirmation_number = $delivered_confirmation_number;
                    // $stock->save();
                    $stock = new TransferRequest();
                    $stock->from_warehouse_id = $validatedData['from_warehouse_id'];
                    $stock->to_warehouse_id = $validatedData['to_warehouse_id'];
                    $stock->quantity = $stockQuantity;
                    $stock->size=$size;
                    $stock->price=$price;
                    $stock->product_id = $productId;
                    $stock->notes = $validatedData['note'];
                    $stock->transfer_date = $validatedData['transfer_date'];
                    $stock->shipped_confirmation_number = $shipped_confirmation_number;
                    $stock->delivered_confirmation_number = $delivered_confirmation_number;
                    $stock->save();


                    Alert::toast('Transfer request sent to '.$destination_warehouse->name.'!!', 'success');
                    return redirect()->back();
                } else {
                    // Rollback the transfer due to insufficient stock
                    Alert::toast('Product or Warehouse not found', 'error');
                    return redirect()->back();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete transfer product')) {
                return view('admin.errors.unauthorized');
            }
            $assing_to_deliveryboy = AssignStockProduct::find($id);
            // dd($assing_to_deliveryboy);
            $deliveryman = $assing_to_deliveryboy->deliveryMan->id;
            if ($deliveryman) {
                $delivery_boy = DeliveryMan::find($deliveryman);
                $delivery_boy->status = "available";
                $delivery_boy->update();
            }
            $assing_to_deliveryboy->delete();

            Alert::toast('Assigned transfer stock product deleted!', 'error');
            return redirect()->route('assigned-stock-product-to-deliveryman');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function assign()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('assign transfer product to deliveryman')) {
                return view('admin.errors.unauthorized');
            }

            $deliverymans = DeliveryMan::all()->where('status', 'available');
            $stock_transfer_product = Transfer_stock_product::whereIn('assign_to_deliveryman', ['0', '1'])
                ->where('is_final_destination','no')
                ->get();
            // dd($stock_transfer_product);
            $appsettings = AppSetting::all()->toArray();
            // dd($deliverymans);
            // dd($stock_transfer_product);
            return view('admin.transfer_stocks.assing_to_delivery_man.assign', compact('appsettings', 'deliverymans', 'stock_transfer_product'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function assignProducts(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('assign transfer product to deliveryman')) {
                return view('admin.errors.unauthorized');
            }

            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            // dd($request->all());
            $request->validate([
                'delivery_man' => 'required',
                'product_in_stock' => 'required',
                'is_final_destination' => 'required'
            ]);

            $deliveryManId = $request->input('delivery_man');
            $productIds = $request->input('product_in_stock');

            $product_stock = Transfer_stock_product::where('id', $productIds)->first();
            $product_stock_id = $product_stock->id;

            // dd($product_stock_id);
            $deliveryMan = DeliveryMan::find($deliveryManId);

            foreach ($productIds as $productId) {
                $product = Transfer_stock_product::find($productId);
                $product->assign_to_deliveryman = 1;
                $product->is_final_destination = $request->input('is_final_destination');
                $product->save();

                $assignment = new AssignStockProduct();
                $assignment->transfer_stock_product()->associate($product);
                $assignment->deliveryMan()->associate($deliveryMan);
                $assignment->save();
            }
            $deliveryMan->status = "delivering";
            $deliveryMan->update();

            Alert::toast('Assign successfully!', 'success');
            return redirect()->route('assign-to-deliveryman');
            // Redirect or show success message
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function transfered_stock_product()
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view transfered stock product')) {
                return view('admin.errors.unauthorized');
            }
            $user_id=Auth::guard('admin')->user()->id;
            $warehouse_manager=WarehouseManager::where('manager_id',$user_id)->first();
            if($warehouse_manager){
                $all_product_stocks = Transfer_stock_product::with('product', 'fromWarehouse', 'toWarehouse')->where('from_warehouse_id',$warehouse_manager->warehouse_id)->orWhere('to_warehouse_id',$warehouse_manager->warehouse_id)->get();
                $transferStockProductIds = $all_product_stocks->pluck('id')->toArray();
                $transfered_stock_product = AssignStockProduct::with('transfer_stock_product', 'deliveryMan')->where('transfer_stock_product_id',$transferStockProductIds)->get();
            }else{
            $transfered_stock_product = AssignStockProduct::with('transfer_stock_product', 'deliveryMan')->get();
            }
            // dd($transfered_stock_product);
            $appsettings = AppSetting::all()->toArray();
            return view('admin.transfer_stocks.assing_to_delivery_man.assigned_to_delivery', compact('appsettings', 'transfered_stock_product'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}