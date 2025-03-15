<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CustomOrder;
use App\Models\CustomOrderProduct;
use App\Models\DeliveryMan;
use App\Models\FastOrders;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CustomOrderController extends Controller
{
    //
    public function index(){
        try{
        $user = Auth::guard('admin')->user();
        if ($user && !$user->hasPermissionByRole('view custom order')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $deliveryBoy = DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();

        $custom_orders=CustomOrder::with('custom_order_product')->where('delivery_boy_id',$deliveryBoy->id)->get()->toArray();
        // dd($fast_orders);
        return view('delivery_man.custom_order.index',compact('custom_orders','appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function detail($id){
        try{
        $user = Auth::guard('admin')->user();
        if ($user && !$user->hasPermissionByRole('view custom order detail')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $order_status=OrderStatus::all()->where('status',1)->toArray();
        $custom_orders=CustomOrder::with('custom_order_product')->where('id',$id)->get();
       //  dd($alldelivery_boys);
        return view('delivery_man.custom_order.detail',compact('appsettings','custom_orders','order_status'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
       }

     public function update_delivery_status(Request $request){

        // dd($request->all());
        try{

            $user = Auth::guard('admin')->user();
            if ($user && !$user->hasPermissionByRole('update custom order status')) {
                return view('admin.errors.unauthorized');
            }
        if ($request['delivery_status'] == 'Delivered') {
            $custom_orders= CustomOrder::where('id',$request['custom_order_id'])->first();
            if ($custom_orders->user_code == $request['user_code']){
                CustomOrder::where('id',$request['custom_order_id'])->update(['delivery_status'=>$request['delivery_status']]);
                //update courier name & tracking number
               Alert::toast('Delivery status updated successfully', 'success');
                return redirect()->back();
            }else{
               Alert::toast('Invalid User code. Ordered Product Status not updated.', 'error');
                return redirect()->back();
            }
        }else{

        CustomOrder::where('id',$request['custom_order_id'])->update(['delivery_status'=>$request['delivery_status']]);
        Alert::toast('Delivery status updated successfully', 'success');
        return redirect()->back();
        }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
     }

     public function update_product_delivery_status(Request $request){
       try{
        // dd($request->all());
        $user = Auth::guard('admin')->user();
        if ($user && !$user->hasPermissionByRole('update custom order status')) {
            return view('admin.errors.unauthorized');
        }
        if ($request['product_delivery_status'] == 'Shipped') {
            $custom_orders_product= CustomOrderProduct::where('id',$request['custom_order_product_id'])->first();
            if ($custom_orders_product->vendor_code == $request['vendor_code']){
                CustomOrderProduct::where('id',$request['custom_order_product_id'])->update(['delivery_status'=>$request['product_delivery_status']]);
                //update courier name & tracking number
               Alert::toast('Product delivery status updated successfully', 'success');
                return redirect()->back();
            }else{
               Alert::toast('Invalid User code. Ordered Product Status not updated.', 'error');
                return redirect()->back();
            }
        }else{

        CustomOrderProduct::where('id',$request['custom_order_product_id'])->update(['delivery_status'=>$request['product_delivery_status']]);
       Alert::toast('Delivery status updated successfully', 'success');
        return redirect()->back();
        }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
     }

      public function viewinvoice($id){
        try{
        $user = Auth::guard('admin')->user();
        if ($user && !$user->hasPermissionByRole('view custom order invoice')) {
            return view('admin.errors.unauthorized');
        }
        $custom_order=CustomOrder::with('custom_order_product')->where('id',$id)->first();
        // dd($custom_order);
        $appsettings=AppSetting::all()->toArray();

        return view('admin.custom_order.view_invoice',compact('custom_order','appsettings','id'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
      }




}
