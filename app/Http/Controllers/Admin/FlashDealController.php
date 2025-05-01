<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class FlashDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view_flash_deal')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings = AppSetting::all()->toArray();
        // $sort_search = null;
        $flash_deals = FlashDeal::orderBy('created_at', 'desc');

        $flash_deals = $flash_deals->paginate(15);
        return view('admin.flashdeal.index', compact('flash_deals', 'appsettings'));
    }
    public function create()
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('add_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings = AppSetting::all()->toArray();
        return view('admin.flashdeal.create', compact('appsettings'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('add_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $flash_deal = new FlashDeal();
        $flash_deal->title = $request->title;
        $flash_deal->text_color = $request->text_color;
        $flash_deal->start_date = Carbon::createFromFormat('d-m-Y H:i:s', $request->start_date)->format('Y-m-d H:i:s');
        $flash_deal->end_date = Carbon::createFromFormat('d-m-Y H:i:s', $request->end_date)->format('Y-m-d H:i:s');

        $flash_deal->background_color = $request->background_color;
        $flash_deal->slug = Str::slug($request->title) . '-' . Str::random(5);


        if ($request->hasFile('banner')) {
            // Get original file name with extension
            $fileNameWithExt = $request->file('banner')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('banner')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // Store the file
            $path = $request->file('banner')->storeAs('public/banners', $fileNameToStore);

            // Store the full URL in the database
            $flash_deal->banner = asset('storage/banners/' . $fileNameToStore);
        }

        // $flash_deal->banner = $request->banner;
        if ($flash_deal->save()) {
            foreach ($request->products as $key => $product) {
                $flash_deal_product = new FlashDealProduct();
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $product;
                $flash_deal_product->save();

                $root_product = Product::findOrFail($product);
                $root_product->product_discount = $request['discount_' . $product];
                $root_product->discount_start_date = $request->start_date;
                $root_product->discount_end_date   = $request->end_date;

                $root_product->save();
            }


            Alert::toast('Flash Deal has been saved', 'success');
            return redirect()->route('flash_deals.index');
        } else {

            Alert::toast('Something went wrong', 'error');
            return back();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings = AppSetting::all()->toArray();
        $flash_deal = FlashDeal::findOrFail($id);
        return view('admin.flashdeal.edit', compact('flash_deal', 'appsettings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $flash_deal = FlashDeal::findOrFail($id);

        $flash_deal->text_color = $request->text_color;

        $date_var               = explode(" to ", $request->date_range);
        $flash_deal->start_date = Carbon::createFromFormat('d-m-Y H:i:s', $request->start_date)->format('Y-m-d H:i:s');
        $flash_deal->end_date = Carbon::createFromFormat('d-m-Y H:i:s', $request->end_date)->format('Y-m-d H:i:s');

        $flash_deal->background_color = $request->background_color;

        $flash_deal->title = $request->title;

        if ($request->hasFile('banner')) {
            // Check if the old banner exists and delete it
            if ($flash_deal->banner && Storage::disk('public')->exists('banners/' . $flash_deal->banner)) {
                // Delete the old banner image from storage
                Storage::disk('public')->delete('banners/' . $flash_deal->banner);
            }

            // Get original file name with extension
            $fileNameWithExt = $request->file('banner')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('banner')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // Store the new banner image
            $path = $request->file('banner')->storeAs('public/banners', $fileNameToStore);

            // Save the new banner URL to the DB
            $flash_deal->banner = asset('storage/banners/' . $fileNameToStore);
        }

        foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product) {
            $flash_deal_product->delete();
        }
        if ($flash_deal->save()) {
            foreach ($request->products as $key => $product) {
                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $product;
                $flash_deal_product->save();

                $root_product = Product::findOrFail($product);
                $root_product->product_discount = $request['discount_' . $product];
                $root_product->discount_start_date = $request->start_date;
                $root_product->discount_end_date   = $request->end_date;

                $root_product->save();
            }

            Alert::toast('Flash deal has been updated!', 'success');
            return redirect()->route('flash_deals.index');
        } else {
            notify()->success('Something went wrong');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $flash_deal = FlashDeal::findOrFail($id);
        $flash_deal->flash_deal_products()->delete();

        FlashDeal::destroy($id);

        Alert::toast('Flash deal has been deleted!', 'success');
        return redirect()->route('flash_deals.index');
    }

    public function active($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $allflashdeals = FlashDeal::where('status', 1)->count();
        if ($allflashdeals >= 1) {
            Alert::toast('You can not inactive all flash deals, you can only active 1 flashdeal!!', 'error');
            return back();
        } else {
            $flash_deal = FlashDeal::findOrFail($id);
            $flash_deal->status = 1;
            $flash_deal->save();
            Alert::toast('Flash deal status has been actived!', 'success');
            return back();
        }
    }

    public function inactive($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        $allflashdeals = FlashDeal::where('status', 1)->count();
        // dd($allflashdeals);

        $flash_deal = FlashDeal::findOrFail($id);
        $flash_deal->status = 0;
        $flash_deal->save();
        Alert::toast('Flash deal status has been inactived!', 'info');

        return back();
    }

    public function update_featured(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_flashdeal')) {
            return view('admin.errors.unauthorized');
        }
        foreach (FlashDeal::all() as $key => $flash_deal) {
            $flash_deal->featured = 0;
            $flash_deal->save();
        }
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->featured = $request->featured;
        if ($flash_deal->save()) {
            Alert::toast('Flash deal updated!', 'success');
            return 1;
        }
        return 0;
    }

    public function product_discount(Request $request)
    {
        $product_ids = $request->product_ids;
        return view('admin.flashdeal.flash_deal_discount', compact('product_ids'));
    }

    public function product_discount_edit(Request $request)
    {
        $product_ids = $request->product_ids;
        $flash_deal_id = $request->flash_deal_id;
        return view('admin.flashdeal.flash_deal_discount_edit', compact('product_ids', 'flash_deal_id'));
    }
}
