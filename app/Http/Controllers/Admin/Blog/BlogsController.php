<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\Http\Request;
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
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('image')->storeAs('public/blog/', $fileNameToStore);

                //   $image = Image::make(public_path('storage/blog/' . $fileNameToStore));

                //   $image->resize(139, 97)->save(public_path('storage/blog/' . $fileNameToStore));
                $blog->image = $fileNameToStore;
            }

            $blog->title = $request->input('title');
            $blog->category_id=$request->input('category_id');
            $blog->description=$request->input('message');
            $blog->status = 1;
            $blog->added_by=$admin_id;
            $blog->save();

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

                if ($blog->image) {
                    Storage::delete('public/blog/' . $blog->image);
                }
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('image')->storeAs('public/blog/', $fileNameToStore);

                //   $image = Image::make(public_path('storage/blog/' . $fileNameToStore));

                //   $image->resize(139, 97)->save(public_path('storage/blog/' . $fileNameToStore));
                $blog->image = $fileNameToStore;
            }
            $blog->title = $request->input('title');
            $blog->category_id=$request->input('category_id');
            $blog->description=$request->input('message');
            $blog->update();

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
            if (!$user || !$user->hasPermissionByRole('delete blog')) {
                return view('admin.errors.unauthorized');
            }
            $blog = Blogs::find($id);
            if ($blog->image) {
                Storage::delete('public/blog/' . $blog->image);
            }
            $blog->delete();

            Alert::toast('Blog  has been deleted successfully!', 'error');
            return redirect()->route('blogs');
        } catch (\Exception $e) {
            // Handle exceptions or errors
            Alert::toast('something is wrong!!', 'error');
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
