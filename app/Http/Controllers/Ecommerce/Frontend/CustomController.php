<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomController extends Controller
{
    //

    public function index(){
       
        return view('Ecommerce.custom_orders.track_custom_order');

    }
    public function showOrderDetails($order_id)
    {
        try {
           
            $custom_order = CustomOrder::with('custom_order_product')->where('order_number', $order_id)->first();

            if ($custom_order) {
                return view('Ecommerce.custom_orders.my_custom_orders', ['custom_order' => $custom_order]);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function checkcustomorder(Request $request){

            try {

                // dd($request->all());
                if ($request->method('post')) {
                    $request->validate([
                        'phone_number' => 'required',
                        // 'billing_email' => 'required|email',
                    ]);

                    if ($request->input('name')) {
                        $custom_order =CustomOrder::with('custom_order_product')->where('phone_number', $request->input('phone_number'))
                            ->where('customer_name',$request->input('name'))
                            ->first();
                            // dd($custom_order);
                        if ($custom_order) {
                            Alert::toast("your order found", 'success');
                            return redirect()->route('create_custom_order', ['id' => $custom_order->order_number]);
                        } else {
                            Alert::toast('Your custom order phone number or billing name is not correct!', 'error');
                            return redirect()->back();
                        }
                    } else {

                        $custom_order =CustomOrder::with('custom_order_product')->where('phone_number', $request->input('phone_number'))
                        ->first();

                         if ($custom_order) {
                            // dd($custom_order->id);
                           
                            Alert::toast("your custom order found", 'success');
                            return redirect()->route('create_custom_order', ['id' => $custom_order->order_number]);
                        } else {
                            Alert::toast('Your custom order  or billing phone number is not correct!', 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    abort(404);
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                // Laravel's built-in validation exception
                return redirect()->back()->withErrors($e->validator->errors())->withInput();
            } catch (\Exception $e) {
                // Log or handle the exception as needed
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

    }

}