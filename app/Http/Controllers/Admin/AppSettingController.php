<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Intervention\Image\ImageManagerStatic as Image;
use RealRashid\SweetAlert\Facades\Alert;

class AppSettingController extends Controller
{
    //
    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_appsetting')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::where('id', 1)->get();
            $appsetting = AppSetting::where('id', 1)->first();

            return view('admin.app_setting.app_settings', compact('appsetting', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required',
                'address' => 'required',
                'email' => 'email',
                'phone_no' => 'required',
                'language' => 'required',
                'footer_text' => 'required',
                'plane_footer_text' => 'required',
            ]);

            $appsettings = AppSetting::find(1);

            if (!$appsettings) {
                throw new \Exception('Application settings not found.');
            }

            $appsettings->application_title = $request->input('title');
            $appsettings->description = $request->input('description');
            $appsettings->address = $request->input('address');
            $appsettings->email_address = $request->input('email');
            $appsettings->phone_no = $request->input('phone_no');
            $appsettings->facebook = $request->input('facebook');
            $appsettings->twitter = $request->input('twitter');
            $appsettings->youtube = $request->input('youtube');
            $appsettings->panel_footer_text = $request->input('plane_footer_text');
            $appsettings->whatsapp = $request->input('whatsapp');

            if ($request->hasFile('favicon')) {
                if ($appsettings->favicon != 'noimage.jpg') {
                    Storage::delete('public/appsettings/' . $appsettings->favicon);
                }

                $fileNameWithExt = $request->file('favicon')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('favicon')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('favicon')->storeAs('public/appsettings', $fileNameToStore);

                // $image = Image::make(public_path('storage/appsettings/' . $fileNameToStore));
                // $image->resize(32, 32)->save(public_path('storage/appsettings/' . $fileNameToStore));

                $appsettings->favicon = $fileNameToStore;
            }

            if ($request->hasFile('footer_image')) {
                if ($appsettings->footer_image != 'noimage.jpg') {
                    Storage::delete('public/appsettings/' . $appsettings->favicon);
                }

                $fileNameWithExt = $request->file('footer_image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('footer_image')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('footer_image')->storeAs('public/appsettings', $fileNameToStore);

                // $image = Image::make(public_path('storage/appsettings/' . $fileNameToStore));
                // $image->resize(500, 86)->save(public_path('storage/appsettings/' . $fileNameToStore));

                $appsettings->footer_image = $fileNameToStore;
            }

            if ($request->hasFile('panel_icon')) {
                if ($appsettings->panel_icon != 'noimage.jpg') {
                    Storage::delete('public/appsettings/' . $appsettings->panel_icon);
                }

                $fileNameWithExt = $request->file('panel_icon')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('panel_icon')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('panel_icon')->storeAs('public/appsettings', $fileNameToStore);

                // $image = Image::make(public_path('storage/appsettings/' . $fileNameToStore));
                // $image->resize(500, 86)->save(public_path('storage/appsettings/' . $fileNameToStore));

                $appsettings->panel_icon = $fileNameToStore;
            }

            if ($request->hasFile('logo')) {
                if ($appsettings->logo != 'noimage.jpg') {
                    Storage::delete('public/appsettings/' . $appsettings->logo);
                }

                $fileNameWithExt = $request->file('logo')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('logo')->storeAs('public/appsettings', $fileNameToStore);
                // $image = Image::make(public_path('storage/appsettings/' . $fileNameToStore));
                // $image->resize(500, 86)->save(public_path('storage/appsettings/' . $fileNameToStore));

                $appsettings->logo = $fileNameToStore;
            }

            $appsettings->language = $request->input('language');
            $appsettings->footer_text = $request->input('footer_text');
            $appsettings->update();

            Alert::toast('Website Settings has been updated!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();

        } catch (\Exception $e) {
            // Handle exceptions
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}