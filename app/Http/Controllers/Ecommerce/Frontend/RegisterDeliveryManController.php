<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Delivery_Man_Type;
use App\Models\Delivery_Zone;
use App\Models\DeliveryMan;
use App\Models\State;
use App\Models\Vehicle_Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterDeliveryManController extends Controller
{
    public function create()
    {
        try {

            $delivery_man_type = Delivery_Man_Type::where('status', 1)->get();
            $delivery_zone = Delivery_Zone::where('status', 1)->get();
            $vehicle_type = Vehicle_Type::where('status', 1)->get();
            $city = City::where('status', 1)->get();
            $state = State::where('status', 1)->get();
            $country = Country::where('status', 1)->get();


            return view('auth.delivery_man.index', compact( 'city', 'state', 'country', 'vehicle_type', 'delivery_zone', 'delivery_man_type'));
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {

            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                return redirect()->back();
            }
            //    dd($request->all());
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'delivery_man_image' => 'required|image',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'identity_type' => 'required',
                'identity_number' => 'required',
                'identity_image' => 'required|image',
                'phone' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
                // 'delivery_man_type' => 'required',
                'delivery_zone' => 'required',
                'vehicle_type' => 'required',
                'driving_license_number' => 'required',
            ]);

            // Create a new Deliveryman instance
            $deliveryBoy = new DeliveryMan();
            $deliveryBoy->first_name = $validatedData['first_name'];
            $deliveryBoy->last_name = $validatedData['last_name'];
            $deliveryBoy->address = $validatedData['address'];
            $deliveryBoy->country = $validatedData['country'];
            $deliveryBoy->state = $validatedData['state'];
            $deliveryBoy->city = $validatedData['city'];
            $deliveryBoy->identity_type = $validatedData['identity_type'];
            $deliveryBoy->identity_number = $validatedData['identity_number'];
            $deliveryBoy->phone = $validatedData['phone'];
            $deliveryBoy->email = $validatedData['email'];
            $deliveryBoy->password = bcrypt($validatedData['password']);
            // $deliveryBoy->delivery_man_type = $validatedData['delivery_man_type'];
            $deliveryBoy->delivery_zone = $validatedData['delivery_zone'];
            $deliveryBoy->vehicle_type = $validatedData['vehicle_type'];
            $deliveryBoy->driving_license_number = $validatedData['driving_license_number'];


            if ($request->hasFile('delivery_man_image')) {
                $file = $request->file('delivery_man_image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('public/delivery_man', $fileNameToStore);
                $deliveryBoy->delivery_man_image = asset('storage/delivery_man/' . $fileNameToStore);
            }

            if ($request->hasFile('identity_image')) {
                $file = $request->file('identity_image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('public/delivery_man', $fileNameToStore);
                $deliveryBoy->identity_image = asset('storage/delivery_man/' . $fileNameToStore);
            }

            if ($request->hasFile('driving_license_image')) {
                $file = $request->file('driving_license_image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('public/delivery_man', $fileNameToStore);
                $deliveryBoy->driving_license_image = asset('storage/delivery_man/' . $fileNameToStore);
            }

            // Save the deliveryman to the database
            $deliveryBoy->save();
          return redirect()->back()->with('success', 'Deliveryman account has been created successfully. Please contact admin to activate your account.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
