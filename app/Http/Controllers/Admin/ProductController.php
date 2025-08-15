<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\Product\AddProduct;
use App\Models\AdminsRole;
use App\Models\AppSetting;
use App\Models\Roles;
use Illuminate\Support\Facades\Storage;
use App\Models\Group;

use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\Category;
use App\Models\Color;
use App\Models\Month;
use App\Models\ProductAttribute;
use App\Models\ProductFilter;
use App\Models\ProductsImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Contracts\RenderlessTrace;
use RealRashid\SweetAlert\Facades\Alert;
use App\Livewire\ProductDisplay;
use App\Models\WarehouseManager;

class ProductController extends Controller
{
    public function product()
    {
        // try {
            $user = Auth::guard('admin')->user();
            $adminType=Auth::guard('admin')->user()->type;
            // dd(''.$adminType.'');

        $role=Roles::where('name',$adminType)->first();
        $group = $role->group ?? null;
        // dd($group);
        $vendor_id = $user->vendor_id;

        if ($group === "ecommerce") {
            $vendorStatus = $user->status;
            if ($vendorStatus == 0) {
                Alert::toast('Your Vendor Account is not approved yet. Please make sure to fill your valid personal, business, and bank details', 'Inactive Vendor Account!', 'success');
                return redirect('admin/updatevendordetails');
            }
        }

          if ($group !== "general") {
            $products=Product::where('vendor_id',$vendor_id)->paginate(10);
          } else {
            $products = Product::latest()->paginate(10);
          }
            $months=Month::all();

            return view('admin.products.allproducts',compact('products','months'));
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }


    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_product')) {
                return view('admin.errors.unauthorized');
            }

            return view('admin.products.addproduct')->withComponent(AddProduct::class);
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function fetchSubcategory(Request $request)
    {
        $data['states'] = SubCategory::where("category_id", $request->category_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function addproduct(Request $request)
    {

        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong', 'error');
                return redirect()->back();
            }
            $data = $request->all();
            $product = new Product;
            $categoryDetails = Category::find($data['category']);
            $product->group_id = $categoryDetails['group_id'];
            $product->category_id = $data['category'];
            $product->brand_id = $data['brand_id'];
            // $product->subcategory_id=$data['sub_category'];
            $productFilters = ProductFilter::productFilters();
            foreach ($productFilters as $filter) {
                $filterAvailable = ProductFilter::filterAvailable($filter['id'], $data['category']);
                if ($filterAvailable == "Yes") {
                    if (isset($filter['filter_column']) && $data[$filter['filter_column']]) {
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;
            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;

            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }
            if (empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            }
            if (empty($data['product_weight'])) {
                $data['product_weight'] = 0;
            }

            $productcode = Product::where('product_code', $data['product_code'])->count();
            if ($productcode > 0) {
                Alert::toast('Product code is inavalible please enter other product code', 'error');
                return redirect()->back();
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->quantity = $data['quantity'];
            $product->product_selling_price = $data['product_selling_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_tax = $data['product_tax'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            // $product->group_code=$data['group_code'];

            $product->status = 1;
            $product->is_featured = 'Yes';
            if ($request->hasFile('image')) {

                // Get original file name and extension
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();

                // Create unique file name
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store image
                $request->file('image')->storeAs('public/products', $fileNameToStore);

                // Optional resize (requires Intervention Image)
                // $image = Image::make(public_path('storage/products/' . $fileNameToStore))->resize(488, 488);
                // $image->save();

                // Save full image URL
                $product->product_image = asset('storage/products/' . $fileNameToStore);
            }


            if ($request->hasFile('product_video')) {
                // Get file name and extension
                $fileNameWithExt = $request->file('product_video')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('product_video')->getClientOriginalExtension();

                // Generate unique file name
                $fileNameToStorevideo = $fileName . '_' . time() . '.' . $extension;

                // Store video in the 'public/products/video' folder
                $request->file('product_video')->storeAs('public/products/video', $fileNameToStorevideo);

                // Save full URL to DB
                $product->product_video = asset('storage/products/video/' . $fileNameToStorevideo);
            }

            $product->save();

            Alert::toast('Product has been created !', 'success');
            return redirect('admin/products');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function edit($product_id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_product')) {
                return view('admin.errors.unauthorized');
            }
            $categories = Group::with('categories')->get()->toArray();
            $appsettings = AppSetting::all()->toArray();

            $brands = Brand::where('status', 1)->get()->toArray();
            $brand = Brand::where('status', 1)->get();
            // $subcategory=SubCategory::where('status',1)->get()->toArray();
            $data['categories'] = Category::get(["name", "id"])->toArray();
            $product = Product::find($product_id);
            $color = Color::all()->where('status', 1);

            //dd($product);
            return view('admin.products.editproduct', compact('color', 'appsettings', 'categories', 'brands', 'brand', 'product'), $data);
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {

        // try {
            if (!$request->method('put')) {
                Alert::toast('something is wrong', 'error');
                return redirect()->back();
            }
            $data = $request->all();

            $product = Product::find($data['id']);
            $categoryDetails = Category::find($data['category']);
            $product->group_id = $categoryDetails['group_id'];
            $product->category_id = $data['category'];
            $product->brand_id = $data['brand_id'];
            // $product->subcategory_id=$data['sub_category'];

            $productFilters = ProductFilter::productFilters();
            foreach ($productFilters as $filter) {
                $filterAvailable = ProductFilter::filterAvailable($filter['id'], $data['category']);
                if ($filterAvailable == "Yes") {
                    if (isset($filter['filter_column']) && $data[$filter['filter_column']]) {
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }
            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;
            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;

            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->quantity = $data['quantity'];
            $product->product_discount = $data['product_discount'];
            $product->product_tax = $data['product_tax'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if (!empty($product->product_image) && Storage::disk('public')->exists($product->product_image)) {
                    Storage::disk('public')->delete($product->product_image);
                }

                // Get original file name and extension
                $fileNameWithExt = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();

                // Create unique file name
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store image in 'products' folder
                $request->file('image')->storeAs('products', $fileNameToStore, 'public');

                // Save relative path only
                $product->product_image = 'products/' . $fileNameToStore;
            }


            //for upload video
            if ($request->hasFile('product_video')) {
                // Delete old video if it exists
                if (!empty($product->product_video) && Storage::disk('public')->exists($product->product_video)) {
                    Storage::disk('public')->delete($product->product_video);
                }

                // Get file name and extension
                $fileNameWithExt = $request->file('product_video')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('product_video')->getClientOriginalExtension();

                // Generate unique file name
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                // Store video in 'products/video' folder on public disk
                $request->file('product_video')->storeAs('products/video', $fileNameToStore, 'public');

                // Save relative path only
                $product->product_video = 'products/video/' . $fileNameToStore;
            }

            $product->update();

            Alert::toast('Product has been updated!', 'success');
            return redirect('admin/products');

        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    public function add_attribute(Request $request, $id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $product = Product::select('id', 'is_offer_price','product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('attributes')->find($id);

            return view('admin.products.add_attribute', compact('appsettings', 'product'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }



    //for store product attributes into database
    public function addattributes(Request $request)
    {

        // try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $data = $request->all();
            // dd($data);
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    $skuCount = ProductAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', 'Sku already exists Please add another SKU !!');
                    }
                    $sizeCount = ProductAttribute::where(['product_id' => $data['id'], 'size' => $data['size'][$key]])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', 'Size already exists Please add another Size !!');
                    }
                    $product=Product::where('id',$data['id'])->first();

                    $attribute = new ProductAttribute;
                    $attribute->product_id = $data['id'];
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $user_id=Auth::guard('admin')->user()->id;
                    if($user_id=="4"){
                        $attribute->warehouse_id = 1;
                    }else{
                        $warehouse=WarehouseManager::where('manager_id',$user_id)->first();
                        if($warehouse){
                            $attribute->warehouse_id=$warehouse->warehouse_id;
                        }else{
                            Alert::toast('you are not authorize to add product to this warehouse','warning');
                            return back();
                        }
                    }
                    $attribute->save();
                }
            }
            Alert::toast('Attribute has been created!', 'success');
            return redirect()->back();
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }



    //for update product attribute
    public function editAttributes(Request $request)
    {
        try {

            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $data = $request->all();
            // return dd($data);
            foreach ($data['attributeId'] as $key => $attribute) {
                if (!empty($attribute)) {
                    ProductAttribute::where(['id' => $data['attributeId'][$key]])->update([
                        'price' => $data['price'][$key], 'stock' => $data['stock'][$key]
                    ]);
                }
            }

            Alert::toast('Attribute has been created !', 'success');

            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }




    public function active_attribute($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $productattribute = ProductAttribute::find($id);
            $productattribute->status = 1;
            $productattribute->update();
            Alert::toast('Product attribute actived !!', 'success');

            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function inactive_attribute($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $productattribute = ProductAttribute::find($id);
            $productattribute->status = 0;
            $productattribute->update();
            Alert::toast('Product attribute inactive !!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function deleteattribute($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_attribute')) {
                return view('admin.errors.unauthorized');
            }
            $productattribute = ProductAttribute::find($id);
            $productattribute->delete();
            Alert::toast('Product attribute has been deleted !!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    //upload multiple image for products
    public function addImages($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_image_to_product')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_image')->with('images')->find($id);
            return view('admin.products.add_image', compact('appsettings', 'product'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function add_image(Request $request)
    {

        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add_image_to_product')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $data = $request->all();
            //echo"<pre>";print_r('$images'); die;
            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');

                foreach ($uploadedImages as $image) {
                    // Get file name with extension
                    $fileNameWithExt = $image->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    // Upload image to 'storage/app/public/products'
                    $image->storeAs('products', $fileNameToStore, 'public');

                    // Save to DB (relative path only)
                    $productImage = new ProductsImage();
                    $productImage->image = 'products/' . $fileNameToStore; // ✅ Relative path only
                    $productImage->product_id = $data['id'];
                    $productImage->status = 1;
                    $productImage->save();
                }
            }


            Alert::toast('Product image has been created !!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    //for active and inactive product Images

    public function active_ProdcutImage($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_product_image')) {
                return view('admin.errors.unauthorized');
            }
            $productImage = ProductsImage::find($id);
            $productImage->status = 1;
            $productImage->update();
            Alert::toast('Product image actived!', 'success');

            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function inactive_ProductImage($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_product_image')) {
                return view('admin.errors.unauthorized');
            }
            $productattribute = ProductsImage::find($id);
            $productattribute->status = 0;
            $productattribute->update();

            Alert::toast('Product Image inactive !!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function deleteaImageProduct($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_product_image')) {
                return view('admin.errors.unauthorized');
            }
            $productImage = ProductsImage::find($id);

           if ($productImage) {
                // Delete the image file from storage
                if ($productImage->image && Storage::disk('public')->exists($productImage->image)) {
                    Storage::disk('public')->delete($productImage->image);
                }

                // Delete the database record
                $productImage->delete();
            }
            Alert::toast('Product attribute has been deleted!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function is_seasonal($id){
        $product=Product::findOrFail($id);
        if($product){
            $is_seasonal=$product->is_seasonal;
            $product->is_seasonal=!$is_seasonal;
            $product->update();

            Alert::toast('Is seasonal updated','success');
           return redirect()->back();
        }
    }

    public function add_season(Request $request)
    {

        $productId = $request->input('product_id');
        // Sync the season_end_months
        DB::table('product_month')->where('product_id', $productId)->delete();
        if (!empty($request->season_end_months)) {
            foreach ($request->season_end_months as $monthId) {
                DB::table('product_month')->insert([
                    'product_id' => $productId,
                    'month_id' => $monthId
                ]);
            }
        }

       Alert::toast('Product Season updated!','successs');
       return redirect()->back();

   }



   public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->status_comment = $request->status_comment;
        $product->save();

        return redirect()->back()->with('message', 'Product status updated successfully!');
    }

    // Toggle is_seasonal flag
    public function toggleSeasonal($id)
    {
        $product = Product::findOrFail($id);
        $product->is_seasonal = !$product->is_seasonal;
        $product->save();

        Alert::toast('Is seasonal updated', 'success');

        return redirect()->back();
    }

    // Toggle is_featured flag (with permission check)
    public function toggleFeatured($id)
    {
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit_product')) {
            abort(403, 'Unauthorized action.');
        }

        $product = Product::findOrFail($id);
        $product->is_featured = $product->is_featured === "Yes" ? "No" : "Yes";
        $product->save();

        Alert::toast('Product featured status updated', 'success');

        return redirect()->back();
    }

    // Delete product and its image
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }

        $product->delete();

        return redirect()->back()->with('message', 'Product Deleted Successfully');
    }
}
