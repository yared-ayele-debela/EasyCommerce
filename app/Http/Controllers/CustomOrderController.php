<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\CmsPage;
use App\Models\CustomOrder;
use App\Models\CustomOrderProduct;
use App\Models\Email;
use App\Models\FastOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CustomOrderController extends Controller
{
    //
    // public function fast_orders_lists($id){

    //     $fast_orders=FastOrders::find($id);

    //     return view('NewFrontEndPage.fast_orders.fast_orders_list',compact('fast_orders'));
    // }
    public function index(){
        $appsettings = AppSetting::all()->toArray();
        $cms_pages = CmsPage::get()->toArray();
        return view('NewFrontEndPage.custom_orders.track_custom_order',compact('appsettings','cms_pages'));

    }
    public function showOrderDetails($order_id)
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::all()->toArray();
            $custom_order = CustomOrder::with('custom_order_product')->where('order_number', $order_id)->first();

            if ($custom_order) {
                return view('NewFrontEndPage.custom_orders.my_custom_orders', ['custom_order' => $custom_order, 'appsettings' => $appsettings, 'cms_pages' => $cms_pages]);
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
                            $appsettings = AppSetting::all()->toArray();
                            $cms_pages = CmsPage::all()->toArray();
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
                            $appsettings = AppSetting::all()->toArray();
                            $cms_pages = CmsPage::all()->toArray();
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

    public function create_fast_order()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            // $custom_order = CustomOrder::with('custom_order_product')->get();
            // dd($custom_order);

            return view('NewFrontEndPage.custom_orders.my_custom_orders', compact('appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store_fast_order(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_name' => 'required|string',
                'phone_number' => 'required|numeric',
                'productname.*' => 'required|string',
                'quantity.*' => 'required|string',
                'description.*' => 'required|string',
                'delivery_address.*' => 'required|string',
            ]);

            $rules = array(
                'customer_name' => 'required|string',
                'phone_number' => 'required|numeric',
                'productname.*' => 'required|string',
                'quantity.*' => 'required|string',
                'description.*' => 'required|string',
                'delivery_address.*' => 'required|string',
            );

            $error = Validator::make($request->all(), $rules);
            if ($error->fails()) {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }

            $order_number = str_pad(mt_rand(1, 9999), 8, '0', STR_PAD_LEFT);
            $user_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $vendor_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            // dd($user_code);
            $order = CustomOrder::create([
                'order_number'=>$order_number,
                'user_code' => $user_code,
                'customer_name' => $validatedData['customer_name'],
                'phone_number' => $validatedData['phone_number'],
            ]);
            // dd($order);

            // Iterate through the product details and insert into order_product table
            foreach ($validatedData['productname'] as $key => $productName) {
                CustomOrderProduct::create([
                    'vendor_code' => $vendor_code,
                    'order_id' => $order->id,
                    'product_name' => $productName,
                    'quantity' => $validatedData['quantity'][$key],
                    'description' => $validatedData['description'][$key],
                    'delivery_address' => $validatedData['delivery_address'][$key],
                ]);
            }
            // $message = "Hello ";
            // $messages='hello';
            // $receiver= +251912651113;
            // Email::sendSms($receiver,$messages);
            Alert::toast("Custom Order placed successfully!", 'success');
            return redirect()->back();
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