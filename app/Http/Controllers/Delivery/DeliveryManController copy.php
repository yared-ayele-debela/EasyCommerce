<?php

namespace App\Http\Controllers\Delivery;

use App\Helper\Helper;
use App\Http\Controllers\Admin\AssingOrderToDeliveryBoy;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AssignStockProduct;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\CustomOrder;
use App\Models\Delivery_Man_Type;
use App\Models\Delivery_Zone;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCommission;
use App\Models\DeliveryManWithdrawRequest;
use App\Models\Email;
use App\Models\EmailTemplate;
use App\Models\FastOrders;
use App\Models\Order;
use App\Models\OrderItemStatus;
use App\Models\OrderLog;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Models\State;
use App\Models\Transfer_stock_product;
use App\Models\User;
use App\Models\Vehicle_Type;
use Dompdf\Dompdf;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryManController extends Controller
{
    //
   public function login(){
    try{
        $appsettings=AppSetting::all()->toArray();
        return view('delivery_man.login.login',compact('appsettings'));
    } catch (\Exception $e) {
        // Log or handle the exception as needed
        Alert::toast('something is wrong!!','error');
        return redirect()->back();
    }
   }

   public function login_validate(Request $request)
   {
    // try{
       $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required',
       ]);

       if (auth()->guard('deliverymen')->attempt($request->only('email', 'password'))) {
          Alert::toast('Welcome to your dashboard','success');
        return redirect()->route('delivery_man.dashboard');
       }else{


       Alert::toast('Invalid Email or Password','error');
       return back()->withErrors(['email' => 'Invalid credentials']);
              }

    // } catch (\Illuminate\Validation\ValidationException $e) {
    //     // Laravel's built-in validation exception
    //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
    // } catch (\Exception $e) {
    //     // Log or handle the exception as needed
    //     Alert::toast('something is wrong!!','error');
    //     return redirect()->back();
    //  }
   }


   //for forget password
   public function forgetpassword()
   {
       try {
           $appsettings = AppSetting::all()->toArray();
           return view('delivery_man.login.forget', compact('appsettings'));
       }catch (\Exception $e) {
           // Log or handle the exception as needed
           Alert::toast('something is wrong!!', 'error');
           return redirect()->back();
       }
   }
   public function ForgetPasswordStore(Request $request)
   {
       if (!$request->isMethod('post')) {
           // Display an error or handle the incorrect request method
           Alert::toast('Invalid request method!', 'error');
           return back();
       }

       $request->validate([
           'email' => 'required|email|exists:deliverymen',
       ]);

    //    try {
           $token = Str::random(64);

           DB::table('password_resets')->updateOrInsert([
               'email' => $request->email,
           ], [
               'token' => $token,
               'created_at' => Carbon::now()
           ]);

           $email_template = EmailTemplate::first();

           $messageData = [
               'token' => $token,
               'email_template' => $email_template,
           ];

        Mail::send('emails.reset-delivery-man-password', $messageData, function($message) use($request){
            $message->to($request->email);
            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $message->subject('Reset Password');
        });

        Alert::toast('We have emailed your password reset link', 'success');
        return back();

   }
   public function ResetPassword($token)
   {
       try{
        $appsettings = AppSetting::all()->toArray();
           return view('delivery_man.login.forget-password-link',compact('appsettings'), ['token' => $token]);
       } catch (\Exception $e) {
           // Log or handle the exception as needed
           Alert::toast('something is wrong!!', 'error');
           return redirect()->back();
       }
   }


   public function ResetPasswordStore(Request $request)
   {
       // dd($request->all());

       if (!$request->isMethod('post')) {
           Alert::toast('Invalid request method!', 'error');
           return back();
       }

       $request->validate([
           'email' => 'required|email|exists:users',
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required'
       ]);

       $update = DB::table('password_resets')
           ->where(['email' => $request->email, 'token' => $request->token])
           ->first();

       if (!$update) {
           return back()->withInput()->with('error', 'Invalid token!');
       }

       try {
           $user = DeliveryMan::where('email', $request->email)->first();

           if (!$user) {
               return back()->withInput()->with('error', 'User not found!');
           }

           // Hash and update the password
           $user->password = Hash::make($request->password);
           $user->save();

           // Delete password_resets record
           DB::table('password_resets')->where(['email' => $request->email])->delete();

           Alert::toast('Your password has been successfully changed!', 'success');
           return redirect('delivery-boy/login');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
           // Log or handle the exception as needed
           Alert::toast('something is wrong!!', 'error');
           return redirect()->back();
       }
   }



   public function logout(Request $request)
   {
      try{
       auth()->guard('deliverymen')->logout();
       $request->session()->invalidate();
       return redirect('delivery-boy/login');
    } catch (\Exception $e) {
        // Log or handle the exception as needed
        Alert::toast('something is wrong!!','error');
        return redirect()->back();
     }
   }

   public function update_password(){
    try{
    $appsettings=AppSetting::all()->toArray();
    return view('delivery_man.login.update-password',compact('appsettings'));
    } catch (\Exception $e) {
        // Log or handle the exception as needed
        Alert::toast('something is wrong!!','error');
        return redirect()->back();
    }
   }
   public function update_delivery_boy_password(Request $request){
        try{
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required'],
            'new_password_confirmation' => ['same:new_password'],
        ]);

        if(!Hash::check($request->old_password, Auth::guard('deliverymen')->user()->password)){

           Alert::toast('your old password is not correct!','error');
            return back();
        }
        // Current password and new password same
        if (!strcmp($request->get('new_password'), $request->get('new_password_confirmation')) == 0)
        {
            Alert::toast('new password and confirm password  not the same!','error');
            return back();
        }
        #Update the new Password
        DeliveryMan::whereId(Auth::guard('deliverymen')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Alert::toast('Password Updated Succesfully !','success');
        return back();
        } catch (\Illuminate\Validation\ValidationException $e) {
          // Laravel's built-in validation exception
          return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }


    public function update_profile(){
        try{

        $appsettings=AppSetting::all()->toArray();
        $deliveryman= DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();
        // dd($deliveryman);
        $delivery_man_type=Delivery_Man_Type::all()->where('status',1);
        $delivery_zone=Delivery_Zone::all()->where('status',1);
        $vehicle_type=Vehicle_Type::all()->where('status',1);
        $city=City::all()->where('status',1);
        $state=State::all()->where('status',1);
        $country=Country::all()->where('status',1);

        return view('delivery_man.login.update_profile',compact('delivery_man_type','delivery_zone','vehicle_type','city','state','country','deliveryman','appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }

    }


    public function update(Request $request)
    {
        try{
            if(!$request->method('put')){
                Alert::toast('something is wrong!!','error');
                return redirect()->back();
             }
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'identity_type' => 'required',
            'identity_number' => 'required',
            'address' => 'required',
            'email' => 'required|email',

            // 'delivery_man_image' => 'required',
            // 'identity_image' => 'required',
        ]);
        // dd($validatedData);

        // Create a new Deliveryman instance
        $deliveryBoy = Deliveryman::findOrFail($request->input('id'));

        $deliveryBoy->first_name = $request->input('first_name');
        $deliveryBoy->last_name = $request->input('last_name');
        $deliveryBoy->address = $request->input('address');
        $deliveryBoy->country = $request->input('country');
        $deliveryBoy->state = $request->input('state');
        $deliveryBoy->city = $request->input('city');
        $deliveryBoy->identity_type = $request->input('identity_type');
        $deliveryBoy->identity_number = $request->input('identity_number');
        $deliveryBoy->phone = $request->input('phone');
        $deliveryBoy->email = $request->input('email');
        $deliveryBoy->password = bcrypt($request->input('password'));
        $deliveryBoy->delivery_man_type = $request->input('delivery_man_type');
        $deliveryBoy->delivery_zone = $request->input('delivery_zone');
        $deliveryBoy->vehicle_type = $request->input('vehicle_type');
        $deliveryBoy->vehicle_capacity = $request->input('vehicle_capacity');
        $deliveryBoy->driving_license_number = $request->input('driving_license_number');


        if($request->hasFile('delivery_man_image')){
            if ($deliveryBoy->delivery_man_image) {
                Storage::delete('public/delivery_man/'.$deliveryBoy->delivery_man_image);
              }
            //get file name with ext
            $fileNameWithExt=$request->file('delivery_man_image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('delivery_man_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('delivery_man_image')->storeAs('public/delivery_man',$fileNameToStore);
            $deliveryBoy->delivery_man_image=$fileNameToStore;
           }

           if($request->hasFile('identity_image')){
            //get file name with ext
            if ($deliveryBoy->identity_image) {
                Storage::delete('public/delivery_man/'.$deliveryBoy->identity_image);
              }
            $fileNameWithExt=$request->file('identity_image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('identity_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('identity_image')->storeAs('public/delivery_man',$fileNameToStore);
            $deliveryBoy->identity_image=$fileNameToStore;
           }

           if($request->hasFile('driving_license_image')){
            if ($deliveryBoy->driving_license_image) {
                Storage::delete('public/delivery_man/'.$deliveryBoy->driving_license_image);
              }
            //get file name with ext
            $fileNameWithExt=$request->file('driving_license_image')->getClientOriginalName();
            //get just file name
            $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get just file extenstion
            $extension=$request->file('driving_license_image')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;

            //upload image
            $path=$request->file('driving_license_image')->storeAs('public/delivery_man',$fileNameToStore);
            $deliveryBoy->driving_license_image=$fileNameToStore;
           }
        // Save the deliveryman to the database
        $deliveryBoy->save();

        Alert::toast('DeliveryMan has been updated!','success');

        return redirect()->back();
         } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel's built-in validation exception
        return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }






    public function index(){
       try{

        $deliveryManId=Auth::guard('deliverymen')->user()->id;

        $deliveryBoy = DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();
        $orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->orderBy( 'created_at', 'desc')->take(4)->get()->toArray();
        $picked_orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->where('order_status','picked')->count();
        $allorders= Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->count();
        $deliverd_orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->where('order_status','delivered')->count();
        $pending_orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->where('order_status','pending')->count();
        $delivering_orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->where('order_status','delivering')->count();
        $new_orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->where('order_status','new')->count();
        $custom_order= CustomOrder::all()->where('delivery_boy_id',$deliveryBoy->id)->count();

        $stock_transfer_product=AssignStockProduct::all()->where('delivery_man_id',$deliveryBoy->id)->count();

        $appsettings=AppSetting::all()->toArray();

        // Total commissions
        $men=DeliveryMan::where('id',$deliveryManId)->first();
        $available_to_withdraw=$men->total_earn;

        $totalEarned = DeliveryManCommission::where('delivery_man_id', $deliveryManId)
            ->whereIn('status', ['earned', 'withdrawn','pending']) // total earned
            ->sum('commission_amount');

        // Available for withdrawal
        $withdrawn = $totalEarned- $men->total_earn;


        // Pending withdraw requests
        $pendingWithdraw = DeliveryManWithdrawRequest::where('delivery_man_id', $deliveryManId)
            ->where('status', 'pending')
            ->sum('amount');

        // Withdraw history
        $withdrawals = DeliveryManWithdrawRequest::where('delivery_man_id', $deliveryManId)
            ->latest()->get();
        return view('delivery_man.admin_dashboard.index',compact('available_to_withdraw','stock_transfer_product','custom_order','allorders','appsettings','orders','deliverd_orders','pending_orders','delivering_orders','new_orders','picked_orders', 'totalEarned', 'withdrawn', 'pendingWithdraw', 'withdrawals'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }


    public function orders(){
        try{

        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('view_orders')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $deliveryBoy = DeliveryMan::where('id',Auth::guard('deliverymen')->user()->id)->first();
        $orders = Order::with('orders_products')->where('delivery_boy_id',$deliveryBoy->id)->orderBy( 'id', 'Desc')->paginate(2);

        return view('delivery_man.orders.orders',compact('appsettings','orders'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function order_detail($order_id){
        try{
        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('view_orders_details')) {
            return view('admin.errors.unauthorized');
        }
        $orderDetails=Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails=User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatus=OrderStatus::where('status',1)->get()->toArray();
        $orderItemStatus=OrderItemStatus::where('status',1)->get()->toArray();
        $orderLog=OrderLog::with('orders_products')->where('order_id',$order_id)->orderBy('id','Desc')->get()->toArray();

         //Calculate Total Items in Cart
         $total_items=0;
         foreach ($orderDetails['orders_products'] as $product){
             $total_items=$total_items+$product['product_qty'];
         }
         if($orderDetails['coupon_amount']>0){
             $item_discount=round($orderDetails['coupon_amount']/$total_items,2);
         }else{
             $item_discount=0;
         }
         $appsettings=AppSetting::all()->toArray();

         return view('delivery_man.orders.order_details',compact('appsettings','item_discount','orderDetails','orderLog','userDetails','orderStatus','orderItemStatus'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
         }
    }

    public function updateOrderStatus(Request $request){

        // try{
            if(!$request->method('post')){
                Alert::toast('something is wrong!!','error');
                return redirect()->back();
            }
        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('update_order_status')) {
            return view('admin.errors.unauthorized');
        }
        if($request->isMethod('post')){
            $data=$request->all();

            if ($data['order_status'] == 'Delivered' || $data['order_status'] == 'Paid') {
                $order = Order::where('id', $data['order_id'])->first();
                if ($order->order_code == $data['user_code']) {
                    Order::where('id',$data['order_id'])
                    ->update(['order_status'=>$data['order_status']]);
                    $deliveryBoy = DeliveryMan::find(Auth::guard('deliverymen')->user()->id)->first();

                    // $commissionAmount = Helper::calculateDeliveryCommission($order); // e.g., flat or % based

                    // if ($deliveryBoy) {
                    //     $deliveryBoy->status = "available";
                    //     $deliveryBoy->total_earn+=$commissionAmount;
                    //     $deliveryBoy->save();
                    // }


                    // dd($commissionAmount);
                    // DeliveryManCommission::create([
                    //     'delivery_man_id' => $deliveryBoy->id,
                    //     'order_type' =>'goods',
                    //     'order_id' => $order->id,
                    //     'commission_amount' => $commissionAmount,
                    //     'status' => 'pending'
                    // ]);

                    //udate courier Name and Tracking Number
                    if(!empty($data['courier_name'])&&!empty($data['tracking_number'])){
                        Order::where('id',$data['order_id'])->update([
                            'courier_name'=>$data['courier_name'],
                            'tracking_number'=>$data['tracking_number']
                        ]);
                    }
                    $log=new OrderLog();
                    $log->order_id=$data['order_id'];
                    $log->order_status=$data['order_status'];
                    $log->save();

                    $deliveryDetails=Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
                    $orderDetails=Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
                    $email_template=EmailTemplate::first();


                    //Send Order Status Update Email
                    if(!empty($data['courier_name'])&& !empty($data['tracking_number'])){
                        $email=$deliveryDetails['email'];
                        $messageData=[
                        'email_template'=>$email_template,
                        'email'=>$email,
                        'name'=>$deliveryDetails['name'],
                        'order_id'=>$data['order_id'],
                        'orderDetails'=>$orderDetails  ,
                        'order_status'=>$data['order_status'],
                        'courier_name'=>$data['courier_name'],
                        'tracking_number'=>$data['tracking_number'],
                        ];

                        Mail::send('emails.order_status',$messageData,function($message)use ($email){
                            $message->to($email)->subject('Order Status Updated');
                        });
                    }
                    else
                    {
                        $email=$deliveryDetails['email'];
                        $messageData=[
                        'email_template'=>$email_template,
                        'email'=>$email,
                        'name'=>$deliveryDetails['name'],
                        'order_id'=>$data['order_id'],
                        'orderDetails'=>$orderDetails  ,
                        'order_status'=>$data['order_status'],
                        ];

                        Mail::send('emails.order_status',$messageData,function($message)use ($email){
                            $message->to($email)->subject('Order Status Updated  ');
                        });
                    }
                    Alert::toast('Order status ihas been udpated !','success');
                    return redirect()->back();
                }
                else
                {
                    Alert::toast('Invalid user code. Order status not updated.', 'error');
                    return redirect()->back();
                }
            }

            if ($data['order_status'] == 'Shipped'){
                $deliveryBoy = DeliveryMan::find(Auth::guard('deliverymen')->user())->first();
                if ($deliveryBoy) {
                    $deliveryBoy->status = "In Transit";
                    $deliveryBoy->save();
                }
            }

            Order::where('id',$data['order_id'])
            ->update(['order_status'=>$data['order_status']]);

            //udate courier Name and Tracking Number
            if(!empty($data['courier_name'])&&!empty($data['tracking_number'])){
                Order::where('id',$data['order_id'])->update([
                    'courier_name'=>$data['courier_name'],
                    'tracking_number'=>$data['tracking_number']
                ]);
            }
            //Update Order log
             $log=new OrderLog();
             $log->order_id=$data['order_id'];
             $log->order_status=$data['order_status'];
             $log->save();
             $orders_users=Order::with('user')->where('id',$data['order_id'])->first()->toArray();
            $orderNumber=$orders_users['id'];
            $order_code=$orders_users['order_code'];
            $orderStatus=$orders_users['order_status'];
            $appsettings=AppSetting::first()->toArray();


            $companyName=$appsettings['application_title'];
            $phoneNumber=$appsettings['phone_no'];

            $deliveryDetails=Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
            $orderDetails=Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            //Send Order Status Update Email
            $email_template=EmailTemplate::first();

            if(!empty($data['courier_name'])&& !empty($data['tracking_number'])){
                $email=$deliveryDetails['email'];
                $messageData=[
                'email_template'=>$email_template,
                'email'=>$email,
                'name'=>$deliveryDetails['name'],
                'order_id'=>$data['order_id'],
                'orderDetails'=>$orderDetails  ,
                'order_status'=>$data['order_status'],
                'courier_name'=>$data['courier_name'],
                'tracking_number'=>$data['tracking_number'],
                ];

                Mail::send('emails.order_status',$messageData,function($message)use ($email){
                    $message->to($email)->subject('Order Status Updated  ');
                });
            }
            else
            {
                $email=$deliveryDetails['email'];
                $messageData=[
                    'email_template'=>$email_template,
                'email'=>$email,
                'name'=>$deliveryDetails['name'],
                'order_id'=>$data['order_id'],
                'orderDetails'=>$orderDetails  ,
                'order_status'=>$data['order_status'],
                ];

                Mail::send('emails.order_status',$messageData,function($message)use ($email){
                    $message->to($email)->subject('Order Status Updated  ');
                });
           }

            Alert::toast('Order status ihas been udpated !','success');
            return redirect()->back();
        }
    //   } catch (\Exception $e) {
    //     // Log or handle the exception as needed
    //     Alert::toast('something is wrong!!','error');
    //     return redirect()->back();
    //  }
    }


    public function updateOrderItemStatus(Request $request){
        try{

        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('update_order_item_status')) {
            return view('admin.errors.unauthorized');
        }

        if($request->isMethod('post')){
            $data=$request->all();
            if ($data['order_item_status'] == 'Shipped') {
            $order = OrderProduct::where('id',$data['order_item_id'])->first();
            if ($order->order_product_code == $data['vendor_code']){
                OrderProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);
                //update courier name & tracking number
                if(!empty($data['item_courier_name'])&&!empty($data['item_tracking_number'])){
                    OrderProduct::where('id',$data['order_item_id'])->update([
                        'courier_name'=>$data['item_courier_name'],
                        'tracking_number'=>$data['item_tracking_number']
                    ]);
                }

                $getOrderId=OrderProduct::select('order_id')->where('id',$data['order_item_id'])->first()->toArray();

                //Update Order log
                $log=new OrderLog();
                $log->order_id=$getOrderId['order_id'];
                $log->order_item_id=$data['order_item_id'];
                $log->order_status=$data['order_item_status'];
                $log->save();
                //get Delviery Details
                $deliveryDetails=Order::select('mobile','email','name')->where('id',$getOrderId['order_id'])->first()->toArray();
                //to Get Delivery Address
                $order_item_id=$data['order_item_id'];

                $orderDetails=Order::with(['orders_products'=>function($query)use($order_item_id){
                    $query->where('id',$order_item_id);
                }])->where('id',$getOrderId['order_id'])->first()->toArray();
                $email_template=EmailTemplate::first();

                //Send Order Status Update Email
                    if(!empty($data['item_courier_name'])&&!empty($data['item_tracking_number'])){
                        $email=$deliveryDetails['email'];
                        $messageData=[
                        'email_template'=>$email_template,
                        'email'=>$email,
                        'name'=>$deliveryDetails['name'],
                        'order_id'=>$getOrderId['order_id'],
                        'orderDetails'=>$orderDetails  ,
                        'order_status'=>$data['order_item_status'],
                        'courier_name'=>$data['item_courier_name'],
                        'tracking_number'=>$data['item_tracking_number'],
                    ];

                        Mail::send('emails.order_item_status',$messageData,function($message)use ($email){
                            $message->to($email)->subject('Order Item Status Updated  ');
                        });

                    }
                else
                    {
                    $email=$deliveryDetails['email'];
                    $messageData=[
                    'email_template'=>$email_template,
                    'email'=>$email,
                    'name'=>$deliveryDetails['name'],
                    'order_id'=>$getOrderId['order_id'],
                    'orderDetails'=>$orderDetails  ,
                    'order_status'=>$data['order_item_status'],
                    ];

                    Mail::send('emails.order_item_status',$messageData,function($message)use ($email){
                        $message->to($email)->subject('Order Item Status Updated  ');
                    });

                    }
            }else{
                Alert::toast('Invalid Vendor code. Ordered Product Status not updated.', 'error');
                return redirect()->back();
            }
         }


            OrderProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);
            //update courier name & tracking number
            if(!empty($data['item_courier_name'])&&!empty($data['item_tracking_number'])){
                OrderProduct::where('id',$data['order_item_id'])->update([
                    'courier_name'=>$data['item_courier_name'],
                    'tracking_number'=>$data['item_tracking_number']
                ]);
            }

            $getOrderId=OrderProduct::select('order_id')->where('id',$data['order_item_id'])->first()->toArray();

            //Update Order log
            $log=new OrderLog();
            $log->order_id=$getOrderId['order_id'];
            $log->order_item_id=$data['order_item_id'];
            $log->order_status=$data['order_item_status'];
            $log->save();
            //get Delviery Details

            $deliveryDetails=Order::select('mobile','email','name')->where('id',$getOrderId['order_id'])->first()->toArray();
            //to Get Delivery Address
            $order_item_id=$data['order_item_id'];

            $orderDetails=Order::with(['orders_products'=>function($query)use($order_item_id){
                $query->where('id',$order_item_id);
            }])->where('id',$getOrderId['order_id'])->first()->toArray();
            $email_template=EmailTemplate::first();

            //Send Order Status Update Email
                if(!empty($data['item_courier_name'])&&!empty($data['item_tracking_number'])){
                    $email=$deliveryDetails['email'];
                    $messageData=[
                    'email_template'=>$email_template,
                    'email'=>$email,
                    'name'=>$deliveryDetails['name'],
                    'order_id'=>$getOrderId['order_id'],
                    'orderDetails'=>$orderDetails  ,
                    'order_status'=>$data['order_item_status'],
                    'courier_name'=>$data['item_courier_name'],
                    'tracking_number'=>$data['item_tracking_number'],
                ];

                    Mail::send('emails.order_item_status',$messageData,function($message)use ($email){
                        $message->to($email)->subject('Order Item Status Updated ');
                    });

                }
            else
                {
                $email=$deliveryDetails['email'];
                $messageData=[
                'email_template'=>$email_template,
                'email'=>$email,
                'name'=>$deliveryDetails['name'],
                'order_id'=>$getOrderId['order_id'],
                'orderDetails'=>$orderDetails  ,
                'order_status'=>$data['order_item_status'],
                ];

                Mail::send('emails.order_item_status',$messageData,function($message)use ($email){
                    $message->to($email)->subject('Order Item Status Updated  ');
                });

                }

            Alert::toast('Order item status ihas been udpated !','success');
            return redirect()->back();
        }
        } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel's built-in validation exception
         return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }
    }

    public function update_acceptance(Request $request){

            // dd($request->all());
            $order=Order::where('id',$request->input('order_id'))->first();
            $order_id = $request->input('order_id');
            $accepted_product_ids = $request->input('accepted_products', []);
            // dd($accepted_product_ids);
            $product_prices = $request->input('product_prices', []);
            // dd($product_prices);
            $total_price = 0;

            if (!empty($accepted_product_ids)) {
                foreach ($accepted_product_ids as $product_id) {
                    if (isset($product_prices[$product_id])) {
                        $total_price += $product_prices[$product_id];
                    }
                }
            }

            $payments=Payment::where('order_id',$order->id)->first();
            if($payments){
                $payment = Payment::where('order_id',$order->id)->first();
            }else{
                $payment = new Payment();
                $payment_id = Str::random(16);
            }
            $payment->order_id = $order->id;
            $payment->user_id = $order->user_id;
            if(!$payments){
            $payment->payment_id = $payment_id;
            }
            $payment->payer_id = $order->user_id;
            $payment->payer_email = $order->user->email; // Assuming the User model has an email attribute
            $payment->amount = $total_price;
            $payment->currency = 'Birr';
            $payment->payment_status = 'approved';
            if($payments){
            $payment->update();
            }else{
            $payment->save();
            }

            foreach ($accepted_product_ids as $product_id) {
                // dd($product_id);
              $order_product = OrderProduct::where('order_id', $order_id)->where('product_id',$product_id)->first();
            //   dd($order_product);
              $order_product->accepted="accepted";
              $order_product->update();

            }

            Alert::toast('Acceptance updated','success');
            return redirect()->back();
    }

    public function viewOrderInvoice($order_id){
        try{
        $user = Auth::guard('deliverymen')->user();
        if (!$user || !$user->hasPermissionByRole('view_order_invoice')) {
            return view('admin.errors.unauthorized');
        }
        $orderDetails=Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails=User::where('id',$orderDetails['user_id'])->first()->toArray();

        return view('admin.orders.order_invoice',compact('orderDetails','userDetails'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!','error');
            return redirect()->back();
        }

    }

    public function viewPDFInvoice($order_id){
        try{
            $user = Auth::guard('deliverymen')->user();
            if (!$user || !$user->hasPermissionByRole('view_order_invoice')) {
                return view('admin.errors.unauthorized');
            }
        $orderDetails=Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $invoice_settings=InvoiceSetting::first();

        $userDetails=User::where('id',$orderDetails['user_id'])->first()->toArray();
            $dompdf = new Dompdf();

            $invoiceHTML='
                         <!DOCTYPE html>
                        <html>
                        <head>
                            <title>HTML to API - Invoice</title>
                            <meta content="width=device-width, initial-scale=1.0" name="viewport">
                            <meta http-equiv="content-type" content="text-html; charset=utf-8">
                            <style type="text/css">
                                html, body, div, span, applet, object, iframe,
                                h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                                a, abbr, acronym, address, big, cite, code,
                                del, dfn, em, img, ins, kbd, q, s, samp,
                                small, strike, strong, sub, sup, tt, var,
                                b, u, i, center,
                                dl, dt, dd, ol, ul, li,
                                fieldset, form, label, legend,
                                table, caption, tbody, tfoot, thead, tr, th, td,
                                article, aside, canvas, details, embed,
                                figure, figcaption, footer, header, hgroup,
                                menu, nav, output, ruby, section, summary,
                                time, mark, audio, video {
                                    margin: 0;
                                    padding: 0;
                                    border: 0;
                                    font: inherit;
                                    font-size: 100%;
                                    vertical-align: baseline;
                                }

                                html {
                                    line-height: 1;
                                }

                                ol, ul {
                                    list-style: none;
                                }

                                table {
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                }

                                caption, th, td {
                                    text-align: left;
                                    font-weight: normal;
                                    vertical-align: middle;
                                }

                                q, blockquote {
                                    quotes: none;
                                }
                                q:before, q:after, blockquote:before, blockquote:after {
                                    content: "";
                                    content: none;
                                }

                                a img {
                                    border: none;
                                }

                                article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                                    display: block;
                                }

                                body {
                                    font-family: "Source Sans Pro", sans-serif;
                                    font-weight: 300;
                                    font-size: 12px;
                                    margin: 0;
                                    padding: 0;
                                }
                                body a {
                                    text-decoration: none;
                                    color: inherit;
                                }
                                body a:hover {
                                    color: inherit;
                                    opacity: 0.7;
                                }
                                body .container {
                                    min-width: 500px;
                                    margin: 0 auto;
                                    padding: 0 20px;
                                }
                                body .clearfix:after {
                                    content: "";
                                    display: table;
                                    clear: both;
                                }
                                body .left {
                                    float: left;
                                }
                                body .right {
                                    float: right;
                                }
                                body .helper {
                                    display: inline-block;
                                    height: 100%;
                                    vertical-align: middle;
                                }
                                body .no-break {
                                    page-break-inside: avoid;
                                }

                                header {
                                    margin-top: 20px;
                                    margin-bottom: 50px;
                                }
                                header figure {
                                    float: left;
                                    width: 60px;
                                    height: 60px;
                                    margin-right: 10px;
                                    background-color: '.$invoice_settings->background_color.';
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header figure img {
                                    margin-top: 13px;
                                }
                                header .company-address {
                                    float: left;
                                    max-width: 150px;
                                    line-height: 1.7em;
                                }
                                header .company-address .title {
                                    color: '.$invoice_settings->background_color.';
                                    font-weight: 400;
                                    font-size: 1.5em;
                                    text-transform: uppercase;
                                }
                                header .company-contact {
                                    float: right;
                                    height: 60px;
                                    padding: 0 10px;
                                    background-color: '.$invoice_settings->background_color.';
                                    color: white;
                                }
                                header .company-contact span {
                                    display: inline-block;
                                    vertical-align: middle;
                                }
                                header .company-contact .circle {
                                    width: 20px;
                                    height: 20px;
                                    background-color: white;
                                    border-radius: 50%;
                                    text-align: center;
                                }
                                header .company-contact .circle img {
                                    vertical-align: middle;
                                }
                                header .company-contact .phone {
                                    height: 100%;
                                    margin-right: 20px;
                                }
                                header .company-contact .email {
                                    height: 100%;
                                    min-width: 100px;
                                    text-align: right;
                                }

                                section .details {
                                    margin-bottom: 55px;
                                }
                                section .details .client {
                                    width: 50%;
                                    line-height: 20px;
                                }
                                section .details .client .name {
                                    color: '.$invoice_settings->background_color.';
                                }
                                section .details .data {
                                    width: 50%;
                                    text-align: right;
                                }
                                section .details .title {
                                    margin-bottom: 15px;
                                    color: '.$invoice_settings->background_color.';
                                    font-size: 3em;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                    font-size: 0.9166em;
                                }
                                section table .qty, section table .unit, section table .total {
                                    width: 15%;
                                }
                                section table .desc {
                                    width: 55%;
                                }
                                section table thead {
                                    display: table-header-group;
                                    vertical-align: middle;
                                    border-color: inherit;
                                }
                                section table thead th {
                                    padding: 5px 10px;
                                    background: '.$invoice_settings->background_color.';
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #FFFFFF;
                                    text-align: right;
                                    color: white;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                }
                                section table thead th:last-child {
                                    border-right: none;
                                }
                                section table thead .desc {
                                    text-align: left;
                                }
                                section table thead .qty {
                                    text-align: center;
                                }
                                section table tbody td {
                                    padding: 10px;
                                    background: '.$invoice_settings->background_color.';
                                    color:white;
                                    text-align: right;
                                    border-bottom: 5px solid #FFFFFF;
                                    border-right: 4px solid #E8F3DB;
                                }
                                section table tbody td:last-child {
                                    border-right: none;
                                }
                                section table tbody h3 {
                                    margin-bottom: 5px;
                                    color: '.$invoice_settings->background_color.';
                                    font-weight: 600;
                                }
                                section table tbody .desc {
                                    text-align: left;
                                }
                                section table tbody .qty {
                                    text-align: center;
                                }
                                section table.grand-total {
                                    margin-bottom: 45px;
                                }
                                section table.grand-total td {
                                    padding: 5px 10px;
                                    border: none;
                                    color: #777777;
                                    text-align: right;
                                }
                                section table.grand-total .desc {
                                    background-color: transparent;
                                }
                                section table.grand-total tr:last-child td {
                                    font-weight: 600;
                                    color: '.$invoice_settings->background_color.';
                                    font-size: 1.18181818181818em;
                                }

                                footer {
                                    margin-bottom: 20px;
                                }
                                footer .thanks {
                                    margin-bottom: 40px;
                                    color: '.$invoice_settings->background_color.';
                                    font-size: 1.16666666666667em;
                                    font-weight: 600;
                                }
                                footer .notice {
                                    margin-bottom: 25px;
                                }
                                footer .end {
                                    padding-top: 5px;
                                    border-top: 2px solid '.$invoice_settings->background_color.';
                                    text-align: center;
                                }
                            </style>
                        </head>

                        <body>
                            <header class="clearfix">
                                <div class="container">

                                    <div class="company-address">
                                        <h2 class="title">'.$invoice_settings->name.'</h2>
                                        <p>
                                          '.$invoice_settings->address.'
                                        </p><br>
                                        <p>
                                         '.$invoice_settings->email.'
                                        </p><br>
                                        <p>
                                        '.$invoice_settings->phone.'

                                        </p>

                                    </div>
                                </div>
                            </header>

                            <section>
                                <div class="container">
                                    <div class="details clearfix">
                                        <div class="client left">
                                            <p>INVOICE TO:</p>
                                            <p class="name">'.$orderDetails['name'].'</p>
                                            <p>'.$orderDetails['address'].', '.$orderDetails['city'].', '.$orderDetails['state'].',
                                            '.$orderDetails['country'].', '.$orderDetails['pincode'].'
                                            </p>
                                            <a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a>
                                        </div>
                                        <div class="data right">
                                            <div class="title">Order ID: '.$orderDetails['id'].'</div>
                                            <div class="date">
                                                Order Date: '.date('Y-m-d h:i:s',strtotime($orderDetails['created_at'])).'<br>
                                                Order Amount : '.$orderDetails['grand_total'].' BIRR <br>
                                                Order Status : '.$orderDetails['order_status'].' <br>
                                               Payment Method : '.$orderDetails['payment_method'].' <br>

                                            </div>
                                        </div>
                                    </div>

                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="desc">Product Code</th>
                                                <th class="qty">Size</th>
                                                <th class="qty">Color</th>
                                                <th class="qty">Quantity</th>
                                                <th class="unit">Unit Price</th>
                                                <th class="total">Total </th>

                                            </tr>
                                        </thead>
                                        <tbody>';
                                         $subTotal=0;
                                         foreach($orderDetails['orders_products'] as $product){
                                         $invoiceHTML .='<tr>
                                                <td class="desc">'.$product['product_code'].'</td>
                                                <td class="qty">'.$product['product_size'].'</td>
                                                <td class="qty">'.$product['product_color'].'</td>
                                                <td class="qty">'.$product['product_qty'].'</td>
                                                <td class="unit">'.$product['product_price'].'BIRR</td>
                                                <td class="total">'.$product['product_price']*$product['product_qty'].' BIRR</td>
                                            </tr>';
                                            $subTotal=$subTotal+($product['product_price']*$product['product_qty']);
                                         }
                                         $invoiceHTML .='</tbody>
                                    </table>
                                    <div class="no-break">
                                        <table cl ass="grand-total">
                                            <tbody>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>SUBTOTAL:</td>
                                                    <td class="total">'.$subTotal.' BRR</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>SHIPPING</td>
                                                    <td class="total"> 0 BIRR</td>
                                                </tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="unit" colspan=2>DISCOUNT</td>';
                                                    if($orderDetails['coupon_amount']>0){
                                                       $invoiceHTML .='<td class="total">'.$orderDetails['coupon_amount'].' BIRR</td>';
                                                    }else
                                                    {
                                                        $invoiceHTML .='<td class="total"> 0 BIRR </td>';
                                                    }
                                               $invoiceHTML .= '</tr>
                                                <tr>
                                                    <td class="desc"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="qty"></td>
                                                    <td class="total" colspan="2">TOTAL:</td>
                                                    <td class="total">'.$orderDetails['grand_total'].'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <footer>
                                <div class="container">
                                    <div class="thanks">Thank you!</div>
                                    <div class="end">'.$invoice_settings->footer_text.'</div>
                                </div>
                            </footer>

                        </body>

                        </html>

            ';

            $dompdf->loadHtml($invoiceHTML);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();

        return view('admin.orders.order_invoice',compact('orderDetails','userDetails'));
    } catch (\Exception $e) {
        // Log or handle the exception as needed
        Alert::toast('something is wrong!!','error');
        return redirect()->back();
     }
    }


}
