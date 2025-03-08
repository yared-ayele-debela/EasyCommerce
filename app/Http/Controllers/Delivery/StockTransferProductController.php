<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AssignStockProduct;
use App\Models\OrderStatus;
use App\Models\Transfer_stock_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StockTransferProductController extends Controller
{
    //
    public function index(){

        try{
        $user_id=Auth::guard('deliverymen')->user()->id;
        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('view transfer product')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        // dd($user_id);
        $stock_products=AssignStockProduct::where('delivery_man_id',Auth::guard('deliverymen')->user()->id)->get();
        // dd($stock_products);

        return view('delivery_man.stock_product.index',compact('stock_products','appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function detail($id){
        try{
        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('view transfer product detail')) {
            return view('admin.errors.unauthorized');
        }
        $stock_products=AssignStockProduct::with('transfer_stock_product')->where('delivery_man_id',Auth::guard('deliverymen')->user()->id)->where('id',$id)->get();
        // dd($stock_products);
        $appsettings=AppSetting::all()->toArray();

        $delivery_status=OrderStatus::all();
        return view('delivery_man.stock_product.detail',compact('stock_products','appsettings','delivery_status'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function update_status(Request $request){
        try {
            $user = Auth::guard('deliverymen')->user();
            if (!$user || !$user->hasPermissionByRole('update transfer product status')) {
                return view('admin.errors.unauthorized');
            }
            if(!$request->method('post')){
                // Log the error for debugging purposes
                Alert::toast('something is wrong!!','error');
                return redirect()->back();
            }

            $request->validate([
                'delivery_status' => 'required',
            ]);

            $stock = Transfer_stock_product::findOrFail($request->input('stock_transfer_id'));

            $shipped_code = $request->input('shipped_code');
            $delivered_code = $request->input('delivered_code');

            if ($shipped_code) {
                if ($stock->shipped_confirmation_number === $shipped_code) {
                    $stock->delivery_status = $request->input('delivery_status');
                    $stock->update();

                    Alert::toast('Stock product delivery status has been updated', 'success');
                    return redirect()->back();
                } else {
                    throw new \Exception('Invalid shipping confirmation number. Please try again!');
                }
            }

            if ($delivered_code) {
                if ($stock->delivered_confirmation_number === $delivered_code) {
                    $stock->delivery_status = $request->input('delivery_status');
                    $stock->update();

                    Alert::toast('Stock product delivery status has been updated', 'success');
                    return redirect()->back();
                } else {
                    throw new \Exception('Invalid delivery confirmation number. Please try again!');
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }
}
