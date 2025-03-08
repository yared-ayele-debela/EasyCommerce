<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\InvoiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InvoiceSettingController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view invoice')) {
                return view('admin.errors.unauthorized');
            }

            $invoicesetting = InvoiceSetting::paginate(10);
            $appsettings = AppSetting::all()->toArray();
            $invoicesettingsCount = InvoiceSetting::count();

            return view('admin.invoice_settings.index', compact('invoicesetting', 'invoicesettingsCount', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add invoice')) {
                return view('admin.errors.unauthorized');
            }


            $appsettings = AppSetting::all()->toArray();
            return view('admin.invoice_settings.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add invoice')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $invoicesettings = Invoicesetting::all()->count();
            // dd($invoicesettings);
            if ($invoicesettings >= "1") {
                Alert::toast('you can not add the second email template for this webiste, to create another email template delete the first one ', 'error');
                return redirect()->route('invoice_settings');
            } else {

                $request->validate([
                    'name' => 'required|unique:cities',
                    'email' => 'required'
                ]);

                $invoicesettings = new InvoiceSetting();

                if ($request->hasFile('logo')) {
                    if ($invoicesettings->logo) {
                        Storage::delete('public/invoicesettings/' . $invoicesettings->logo);
                    }
                    //get file name with ext
                    $fileNameWithExt = $request->file('logo')->getClientOriginalName();
                    //get just file name
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    //upload logo
                    $path = $request->file('logo')->storeAs('public/invoicesettings/', $fileNameToStore);

                    //   $image = Image::make(public_path('storage/invoicesettings/' . $fileNameToStore));

                    //   $image->resize(139, 97)->save(public_path('storage/invoicesettings/' . $fileNameToStore));

                    $invoicesettings->logo = $fileNameToStore;
                }
                $invoicesettings->name = $request->input('name');
                $invoicesettings->footer_text = $request->input('footer_text');
                $invoicesettings->background_color = $request->input('background_color');
                $invoicesettings->email = $request->input('email');
                $invoicesettings->phone = $request->input('phone');
                $invoicesettings->address = $request->input('address');
                $invoicesettings->save();

                Alert::toast('Invoice Settings has been saved successfully!', 'success');
                return redirect()->route('invoice-settings');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit invoice')) {
                return view('admin.errors.unauthorized');
            }
            $invoicesettings = InvoiceSetting::find($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.invoice_settings.edit', compact('invoicesettings', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {

        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit invoice')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:cities'
            ]);

            $invoicesettings = InvoiceSetting::find($request->input('id'));
            if ($request->hasFile('logo')) {
                if ($invoicesettings->logo) {
                    Storage::delete('public/invoicesettings/' . $invoicesettings->logo);
                }
                //get file name with ext
                $fileNameWithExt = $request->file('logo')->getClientOriginalName();
                //get just file name
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                //get just file extenstion
                $extension = $request->file('logo')->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                //upload logo
                $path = $request->file('logo')->storeAs('public/invoicesettings/', $fileNameToStore);

                //   $image = Image::make(public_path('storage/invoicesettings/' . $fileNameToStore));

                //   $image->resize(139, 97)->save(public_path('storage/invoicesettings/' . $fileNameToStore));

                $invoicesettings->logo = $fileNameToStore;
            }
            $invoicesettings->name = $request->input('name');
            $invoicesettings->footer_text = $request->input('footer_text');
            $invoicesettings->background_color = $request->input('background_color');
            $invoicesettings->email = $request->input('email');
            $invoicesettings->phone = $request->input('phone');
            $invoicesettings->address = $request->input('address');
            $invoicesettings->update();

            Alert::toast('Invoice Settings has been updated successfully!', 'success');
            return redirect()->route('invoice-settings');
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
            if (!$user || !$user->hasPermissionByRole('delete invoice')) {
                return view('admin.errors.unauthorized');
            }
            $invoicesettings = InvoiceSetting::find($id);
            $invoicesettings->delete();

            Alert::toast('Invoice Settings has been deleted successfully!', 'error');
            return redirect()->route('invoice-settings');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit invoice')) {
                return view('admin.errors.unauthorized');
            }
            $invoicesettings = InvoiceSetting::find($id);
            $invoicesettings->status = 1;
            $invoicesettings->save();

            Alert::toast('Invoice Settings has been activated!', 'success');
            return redirect()->route('invoice-settings');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit invoice')) {
                return view('admin.errors.unauthorized');
            }
            $invoicesettings = InvoiceSetting::find($id);
            $invoicesettings->status = 0;
            $invoicesettings->save();

            Alert::toast('Invoice Settings has been inactivated!', 'error');
            return redirect()->route('invoice-settings');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
