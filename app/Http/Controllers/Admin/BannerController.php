<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Banner;
use Intervention\Image\ImageManager as Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use function PHPUnit\Framework\returnSelf;

class BannerController extends Controller
{
    //
    public function banners(Request $request)
    {
        try {
            $banners = Banner::get()->toArray();

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'type'=>'required',
                    'title' => 'required|string',
                    'image'=>'required|image',
                ]);

                // Validation passed, proceed with creating the banner

                $banner = new Banner();

                // Image handling based on type (Slider or Fix)
                if($request->input('type')=="Slider"){
                    if($request->hasFile('image')){
                        //get file name with ext
                        $fileNameWithExt=$request->file('image')->getClientOriginalName();
                        //get just file name
                        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                        //get just file extenstion
                        $extension=$request->file('image')->getClientOriginalExtension();
                        //file name to store
                        $fileNameToStore=$fileName.'_'.time().'.'.$extension;
                        //upload image
                        $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);

                        // $image = Image::make(public_path('storage/banner/' . $fileNameToStore));

                        // $image->resize(1200, 400)->save(public_path('storage/banner/' . $fileNameToStore));

                        $banner->image=$fileNameToStore;
                       }
                }
                if($request->input('type')=="Fix"){
                    if($request->hasFile('image')){
                        //get file name with ext
                        $fileNameWithExt=$request->file('image')->getClientOriginalName();
                        //get just file name
                        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                        //get just file extenstion
                        $extension=$request->file('image')->getClientOriginalExtension();
                        //file name to store
                        $fileNameToStore=$fileName.'_'.time().'.'.$extension;
                        //upload image
                        $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);

                        // $image = Image::make(public_path('storage/banner/' . $fileNameToStore));

                        // $image->resize(1110, 192)->save(public_path('storage/banner/' . $fileNameToStore));

                        $banner->image=$fileNameToStore;
                       }
                  }

                // Assign other banner properties
                $banner->link = $request->input('link');
                $banner->type = $request->input('type');
                $banner->title = $request->input('title');
                $banner->alt = $request->input('alt');
                $banner->status = 0;

                $banner->save();

                Alert::toast('Banner has been saved', 'success');
                return redirect('admin/banners');
            }
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_banners')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            return view('admin.banner.allbanner', compact('banners', 'appsettings'));

            // ... (the rest of your code)
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions or errors
            Alert::toast('Something went wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_banners')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();

            return view('admin.banner.addbanner', compact('appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    // public function store(Request $request){


    // }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_banners')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();

            $banner = Banner::find($id);

            if (!$banner) {
                // Handle the case where the banner is not found
                Alert::toast('Banner not found', 'error');
                return redirect('admin/banners');
            }

            return view('admin.banner.editbanner', compact('banner', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('Error editing banner: ' . $e->getMessage(), 'error');
            return redirect('admin/banners');
        }
    }

    public function update(Request $request)
    {
        // try {
            if (!$request->method('put')) {
                // Handle exceptions or errors
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $this->validate($request, [
                'link' => 'required|string',
                'title' => 'required|string',
                'alt' => 'required|string'
            ]);

            $banner = Banner::find($request->input('id'));

            if (!$banner) {
                // Handle the case where the banner is not found
                Alert::toast('Banner not found', 'error');
                return redirect('admin/banners');
            }

            $banner->link = $request->input('link');
            $banner->type = $request->input('type');
            $banner->title = $request->input('title');
            $banner->alt = $request->input('alt');

            if($request->input('type')=="Slider"){
                if($request->hasFile('image')){
                    if($banner->image) {
                        Storage::delete('public/banner/'.$banner->image);
                      }
                    //get file name with ext
                    $fileNameWithExt=$request->file('image')->getClientOriginalName();
                    //get just file name
                    $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension=$request->file('image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore=$fileName.'_'.time().'.'.$extension;
                    //upload image
                    $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);

                    // $image = Image::imagick()->read(public_path('storage/banner/' . $fileNameToStore));

                    // $image->resize(1200, 700)->save(public_path('storage/banner/' . $fileNameToStore));

                    $banner->image=$fileNameToStore;
                   }
            }
            if($request->input('type')=="Fix"){
                if($request->hasFile('image')){
                    if($banner->image) {
                        Storage::delete('public/banner/'.$banner->image);
                      }
                    //get file name with ext
                    $fileNameWithExt=$request->file('image')->getClientOriginalName();
                    //get just file name
                    $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
                    //get just file extenstion
                    $extension=$request->file('image')->getClientOriginalExtension();
                    //file name to store
                    $fileNameToStore=$fileName.'_'.time().'.'.$extension;
                    //upload image
                    $path=$request->file('image')->storeAs('public/banner',$fileNameToStore);

                    // $image = Image::make(public_path('storage/banner/' . $fileNameToStore));

                    // $image->resize(1110, 192)->save(public_path('storage/banner/' . $fileNameToStore));

                    $banner->image=$fileNameToStore;
                   }
              }


            $banner->update();

            Alert::toast('Banner has been updated', 'success');
            return redirect('admin/banners');
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     // Handle exceptions or errors
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    // for active and inactive admin type

    public function active_banner($banner_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_banners')) {
                return view('admin.errors.unauthorized');
            }

            $bannercount = Banner::where('status',1)->count();
            if($bannercount>=6)
            {
                Alert::toast('You have already actived 5 banners. Please inactive any one to active more banner','info');
                return redirect()->back();
            }
            else
            {
            $banner = Banner::find($banner_id);
            $banner->status = 1;
            $banner->update();
            }

            Alert::toast('Banner Status Acitve', 'success');
            return redirect('admin/banners');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function inactive_banner($banner_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_banners')) {
                return view('admin.errors.unauthorized');
            }

            $banner = Banner::find($banner_id);
            $banner->status = 0;
            $banner->update();

            Alert::toast('Banner Status Inactive', 'error');
            return redirect('admin/banners');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($banner_id)
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_banners')) {
                return view('admin.errors.unauthorized');
            }

            $banner = Banner::find($banner_id);

            if (!$banner) {
                // Handle the case where the banner is not found
                Alert::toast('Banner not found', 'error');
                return redirect('admin/banners');
            }

            if ($banner->image) {
                Storage::delete('public/banner/' . $banner->image);
            }

            $banner->delete();

            Alert::toast('Banner has been deleted', 'success');
            return redirect('admin/banners');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
