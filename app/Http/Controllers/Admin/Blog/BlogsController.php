<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\BlogCategory;
use App\Models\Blogs;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogsController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view blog')) {
                return view('admin.errors.unauthorized');
            }
            $blogs = Blogs::paginate(10);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.blog.blogs.index', compact('blogs', 'appsettings'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add blog')) {
                return view('admin.errors.unauthorized');
            }
            $blog_category=BlogCategory::where('status',1)->get();
            $appsettings = AppSetting::all()->toArray();
            return view('admin.blog.blogs.create', compact('appsettings','blog_category'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add blog')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('cities'); // You can redirect to an appropriate location
            }

            $request->validate([
                'title' => 'required|unique:blogs',
                'message'=>'required',
                'category_id'=>'required'
            ]);
            $admin_id=Auth::guard('admin')->user()->name;
            // dd($admin_id);
            // dd($request->all());
            $blog = new Blogs();

           if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store the file in public/storage/blog
                $file->storeAs('blog', $fileNameToStore, 'public');

                // Save only the relative path
                $blog->image = 'blog/' . $fileNameToStore;
            }


            $blog->title       = $request->input('title');
            $blog->category_id = $request->input('category_id');
            $blog->description = $request->input('message');
            $blog->status      = 1;
            $blog->added_by    = $admin_id;
            $blog->save();
 $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Blog', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            Alert::toast('Blog has been saved successfully!', 'success');
            return redirect()->route('blogs');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit blog')) {
                return view('admin.errors.unauthorized');
            }
            $blog_category=BlogCategory::where('status',1)->get();
            $blogs = Blogs::find($id);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.blog.blogs.edit', compact('blogs', 'appsettings','blog_category'));
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit blog')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->route('cities'); // You can redirect to an appropriate location
            }
            $request->validate([
                'title' => 'required',
                'message'=>'required',
                'category_id'=>'required'
            ]);

            $blog = Blogs::find($request->input('id'));

            if ($request->hasFile('image')) {
    // Delete previous image if it exists
    if ($blog->image) {
        // No need to extract from URL if you only store relative path
        Storage::disk('public')->delete($blog->image);
    }

    // Generate unique filename
    $file = $request->file('image');
    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

    // Store image
    $file->storeAs('blog', $fileNameToStore, 'public');

    // Save relative path only
    $blog->image = 'blog/' . $fileNameToStore;
}

            $blog->title = $request->input('title');
            $blog->category_id = $request->input('category_id');
            $blog->description = $request->input('message');
            $blog->update();

 $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log('Update Blog', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

            Alert::toast('Blog has been updated successfully!', 'success');
            return redirect()->route('blogs');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
{
    try {
        $user = Auth::guard('admin')->user();

        // Check if the user has permission to delete blog
        if (!$user || !$user->hasPermissionByRole('delete blog')) {
            return view('admin.errors.unauthorized');
        }

        $blog = Blogs::find($id);

        // Check if the blog has an image and delete it
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
        Storage::disk('public')->delete($blog->image);
    }

        // Delete the blog
        $blog->delete();
 $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log(  'Delete Blog', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        Alert::toast('Blog has been deleted successfully!', 'error');
        return redirect()->route('blogs');
    } catch (\Exception $e) {
        // Handle exceptions or errors
        Alert::toast('Something went wrong!!', 'error');
        return redirect()->back();
    }
}


    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit blog')) {
                return view('admin.errors.unauthorized');
            }
            $blog = Blogs::find($id);
            $blog->status = 1;
            $blog->save();

            Alert::toast('Blog has been activated!', 'success');
            return redirect()->route('blogs');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit blog')) {
                return view('admin.errors.unauthorized');
            }
            $blog = Blogs::find($id);
            $blog->status = 0;
            $blog->save();

            Alert::toast('Blog has been inactivated successfully!', 'error');
            return redirect()->route('blogs');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}