<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Group;
use App\Models\ProductFilter;
use App\Models\ProductFilterValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class FilterController extends Controller
{
    //
    public function filters()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_filters')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            Session::put('page', 'filters');
            $filters = ProductFilter::get()->toArray();

            return view('admin.filters.filters', compact('appsettings', 'filters'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $filters = ProductFilter::find($id);
            if (!$filters) {
                Alert::toast('Product Filters not found!', 'error');
                return redirect('admin/filters');
            }

            $filters->status = 1;
            $filters->update();
            Alert::toast('Product Filters has been activated', 'success');
            return redirect('admin/filters');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $filters = ProductFilter::find($id);
            if (!$filters) {
                Alert::toast('Product Filters not found!', 'error');
                return redirect('admin/filters');
            }

            $filters->status = 0;
            $filters->update();
            Alert::toast('Product Filters has been inactivated', 'error');
            return redirect('admin/filters');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_filters')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            $categories = Group::with('categories')->get()->toArray();

            return view('admin.filters.add_filter', compact('appsettings', 'categories'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_filters')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $data = $this->validate($request, [
                'cat_ids' => 'required',
                'filter_name' => 'required',
                'fiter_column' => 'required',
            ]);

            $cat_ids = implode(',', $data['cat_ids']);
            $filter = new ProductFilter();
            $filter->cat_ids = $cat_ids;
            $filter->filter_name = $data['filter_name'];
            $filter->filter_column = $data['fiter_column'];
            $filter->status = 1;

            DB::statement('Alter table products add ' . $data['fiter_column'] . ' varchar(255) after description');

            $filter->save();
            Alert::toast('Product Filters has been saved', 'success');

            return redirect('admin/filters');
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
            if (!$user || !$user->hasPermissionByRole('delete_filter')) {
                return view('admin.errors.unauthorized');
            }

            $filter = ProductFilter::findOrFail($id);
            $col_name = $filter->filter_column;
            DB::statement("ALTER TABLE products DROP COLUMN `$col_name`");
            $filter->delete();
            Alert::toast('Product Filter Deleted Successfully!', 'warning');
            return back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function filtersValues()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_filters_value')) {
                return view('admin.errors.unauthorized');
            }

            $appsettings = AppSetting::all()->toArray();
            Session::put('page', 'filters');
            $filters_values = ProductFilterValues::get()->toArray();

            return view('admin.filters.filters_value', compact('appsettings', 'filters_values'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active_filters_value($id)
    {
        try {
            $filters = ProductFilterValues::find($id);
            if (!$filters) {
                Alert::toast('Product Filters not found!', 'error');
                return redirect('admin/filters_value');
            }

            $filters->status = 1;
            $filters->update();
            Alert::toast('Product filters values has been activated', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive_filters_value($id)
    {
        try {
            $filters = ProductFilterValues::find($id);
            if (!$filters) {
                Alert::toast('Product Filters not found!', 'error');
                return redirect('admin/filters_value');
            }

            $filters->status = 0;
            $filters->update();
            Alert::toast('Product filter values has been inactivated', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function createfiltervalues()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_filters_value')) {
                return view('admin.errors.unauthorized');
            }

            $filters = ProductFilter::where('status', 1)->get()->toArray();
            $appsettings = AppSetting::all()->toArray();

            return view('admin.filters.add_filter_value', compact('appsettings', 'filters'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function storefiltervalues(Request $request)
    {
        try {
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('create_filters_value')) {
                return view('admin.errors.unauthorized');
            }
            $data = $this->validate($request, [
                'filter_value' => 'required',
                'filter_id' => 'required',
            ]);

            $filter = new ProductFilterValues();
            $filter->filter_id = $data['filter_id'];
            $filter->filter_value = $data['filter_value'];
            $filter->status = 1;

            $filter->save();
            Alert::toast('Product Filters value has been saved', 'success');

            return redirect('admin/filters_values');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function deletefiltervalue($id)
    {
        try {
            $filter = ProductFilterValues::find($id);
            if ($filter) {
                $filter->delete();
                Alert::toast('Product Filter Value Deleted Successfully!', 'info');
            } else {
                Alert::toast('No such data found!', 'warning');
            }
            return back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function categoryFilters(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = $request->all();
                $category_id = $data['category_id'];
                return response()->json(['view' => (string)View::make('admin.filters.category_filters')->with(compact('category_id'))]);
            } catch (\Exception $e) {
                Alert::toast('An error occurred while fetching category filters!', 'error');
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}