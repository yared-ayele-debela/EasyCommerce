<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Advertisement;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdvertisementController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_advertisment')) {
                return view('admin.errors.unauthorized');
            }
            $adver = Advertisement::all();

            $appsettings = AppSetting::all()->toArray();

            return view('admin.advertisement.alladvertisement', compact('adver', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_advertisment')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();

            return view('admin.advertisement.add_advertisement', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_advertisment')) {
                return view('admin.errors.unauthorized');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'required|image',
                'adver_links' => 'required|string',
            ]);

            $adver = new Advertisement();
            $adver->title = $request->input('title');
            $adver->description = $request->input('description');
            $adver->adv_links = $request->input('adver_links');
            $adver->is_approved = 0;

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if (!$file->isValid()) {
                    throw new \Exception('Invalid file upload.');
                }

                $fileNameWithExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $file->storeAs('public/adver', $fileNameToStore);
                $adver->image = $fileNameToStore;
            }

            $adver->save();
            $appsettings = AppSetting::all()->toArray();

            Alert::toast('Advertisement has been added successfully!', 'success');
            return redirect('admin/adverstisements');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }


    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_advertisment')) {
                return view('admin.errors.unauthorized');
            }

            $adver = Advertisement::find($id);

            if (!$adver) {
                throw new \Exception('Advertisement not found.');
            }

            $appsettings = AppSetting::all()->toArray();

            return view('admin.advertisement.edit_advertisement', compact('adver', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'adver_links' => 'required|string',
            ]);
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_advertisment')) {
                return view('admin.errors.unauthorized');
            }
            $adver = Advertisement::find($request->input('adver_id'));
            $adver->title = $request->input('title');
            $adver->description = $request->input('description');
            $adver->adv_links = $request->input('adver_links');

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if (!$file->isValid()) {
                    throw new \Exception('Invalid file upload.');
                }

                $fileNameWithExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $file->storeAs('public/adver', $fileNameToStore);
                if ($adver->image) {
                    Storage::delete('public/adver/' . $adver->image);
                }
                $path = $file->storeAs('public/adver/', $fileNameToStore);

                $adver->image = $fileNameToStore;
            }

            $adver->update();
            $appsettings = AppSetting::all()->toArray();

            Alert::toast('Advertisement has been updated successfully!', 'success');
            return redirect('admin/adverstisements');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->withErrors([$e->getMessage()])->withInput();
        }
    }
    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_advertisment')) {
                return view('admin.errors.unauthorized');
            }

            $adver = Advertisement::find($id);
            $adver->is_approved = 1;
            $adver->update();

            Alert::toast('advertisement status has been actived!', 'success');
            return redirect('admin/adverstisements');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user || !$user->hasPermissionByRole('edit_advertisment')) {
                return view('admin.errors.unauthorized');
            }
            $adver = Advertisement::find($id);
            $adver->is_approved = 0;
            $adver->update();

            Alert::toast('advertisement status has been inactive!', 'error');
            return redirect('admin/adverstisements');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_advertisment')) {
                return view('admin.errors.unauthorized');
            }

            $adver = Advertisement::find($id);
            if ($adver->image) {
                Storage::delete('public/category/' . $adver->image);
            }
            $adver->delete();

            Alert::toast('advertisement has been deleted successfully!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
