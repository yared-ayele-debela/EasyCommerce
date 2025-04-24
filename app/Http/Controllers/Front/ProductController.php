<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Cart;
use App\Models\Rating;
use App\Models\Vendor;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\City;
use App\Models\CmsPage;
use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Discount;
use App\Models\EmailTemplate;
use App\Models\Offer;
use App\Models\OrderProduct;
use App\Models\ProductAttribute;
use App\Models\ProductFilter;
use App\Models\SalesCommission;
use App\Models\SalesMainCommission;
use App\Models\ShippingCharge;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //
    public function listing(Request $request)
    {
        $appsettings = AppSetting::all()->toArray();
        $cms_pages = CmsPage::get()->toArray();

        if ($request->ajax()) {
            $data = $request->all();
            //   echo "<pre>"; print_r($data); die;

            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            // $url=Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {

                $categoryDetails = Category::categoryDetails($url);
                $allcategoryProducts = Product::all()->toArray();
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                $productFilters = ProductFilter::productFilters();

                foreach ($productFilters as $key => $filter) {
                    if (
                        isset($filter['filter_column']) && isset($data[$filter['filter_column']])
                        && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])
                    ) {
                        $categoryProducts->whereIn($filter['filter_column'], $data[$filter['filter_column']]);
                    }
                }

                if (isset($_GET['sort']) && !empty($_GET['sort'])) {

                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderby('products.id', 'DESC');
                    } elseif ($_GET['sort'] == "price_lowest") {
                        $categoryProducts->orderby('products.product_price', 'ASC');
                    } elseif ($_GET['sort'] == "price_heighst") {
                        $categoryProducts->orderby('products.product_price', 'DESC');
                    } elseif ($_GET['sort'] == "sort_a_z") {
                        $categoryProducts->orderby('products.product_name', 'ASC');
                    } elseif ($_GET['sort'] == "sort_z_a") {
                        $categoryProducts->orderby('products.product_name', 'DESC');
                    }
                }
                //checking for Size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductAttribute::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }
                //checking for Color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                $productIds = array();
                // checking for prince
                if (isset($data['price']) && !empty($data['price'])) {
                    foreach ($data['price'] as $key => $price) {

                        $priceArr = explode("-", $price);
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->pluck('id')->toArray();
                        // echo "<pre>";print_r($productIds); die;
                    }
                    $productIds = call_user_func_array('array_merge', $productIds);

                    $categoryProducts->whereIn("products.id", $productIds);
                }

                // if(isset($data['price'])&& !empty($data['price']))
                // {
                // foreach($data['price'] as $key=>$price){

                //     $priceArr=explode("-",$price);
                //       $productIds[]=Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();

                //     $productIds[]=Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                //     // echo "<pre>";print_r($productIds); die;
                // }
                //     $productIds=array_unique(array_flatten($productIds));

                //     $categoryProducts->whereIn("products.id",$productIds);

                // }

                //checking for brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                $categoryProducts = $categoryProducts->Paginate(10);

                return view('products.ajax_products_listing', compact('cms_pages', 'appsettings', 'url', 'categoryDetails', 'categoryProducts', 'allcategoryProducts'));
            } else {
                abort(404);
            }
        } else {

            if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {

                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['categoryDetails']['category_name'] = $search_product;
                $categoryDetails['categoryDetails']['description'] = "Search Product for " . $search_product;
                $allcategoryProducts = Product::all()->toArray();

                $categoryProducts = Product::select(
                    'products.id',
                    'products.group_id',
                    'products.category_id',
                    'products.brand_id',
                    'products.vendor_id',
                    'products.product_name',
                    'products.product_code',
                    'products.product_color',
                    'products.product_price',
                    'products.product_discount',
                    'products.product_image',
                    'products.description'
                )
                    ->with('brand')->join('categories', 'categories.id', '=', 'products.category_id')
                    ->where(function ($query) use ($search_product) {
                        $query->where('products.product_name', 'like', '%' . $search_product . '%')
                            ->orWhere('products.product_code', 'like', '%' . $search_product . '%')
                            ->orWhere('products.product_color', 'like', '%' . $search_product . '%')
                            ->orWhere('products.description', 'like', '%' . $search_product . '%')
                            ->orWhere('categories.name', 'like', '%' . $search_product . '%');
                    })->where('products.status', 1);
                if (isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id'])) {
                    $categoryProducts = $categoryProducts->where('products.group_id', $_REQUEST['section_id']);
                }

                $categoryProducts = $categoryProducts->get();

                return view('products.listing', compact('cms_pages', 'appsettings', 'categoryDetails', 'categoryProducts', 'allcategoryProducts'));
            } else {
                $url = Route::getFacadeRoot()->current()->uri();
                $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();


                if ($categoryCount > 0) {

                    $categoryDetails = Category::categoryDetails($url);
                    $allcategoryProducts = Product::all()->toArray();
                    $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                    if (isset($_GET['sort']) && !empty($_GET['sort'])) {

                        if ($_GET['sort'] == "product_latest") {
                            $categoryProducts->orderby('products.id', 'DESC');
                        } elseif ($_GET['sort'] == "price_lowest") {
                            $categoryProducts->orderby('products.product_price', 'ASC');
                        } elseif ($_GET['sort'] == "price_heighst") {
                            $categoryProducts->orderby('products.product_price', 'DESC');
                        } elseif ($_GET['sort'] == "sort_a_z") {
                            $categoryProducts->orderby('products.product_name', 'ASC');
                        } elseif ($_GET['sort'] == "sort_z_a") {
                            $categoryProducts->orderby('products.product_name', 'DESC');
                        }
                    }
                    $categoryProducts = $categoryProducts->paginate(10);
                    $appsettings = AppSetting::all()->toArray();
                    // dd($categoryDetails);
                    return view('products.listing', compact('cms_pages', 'appsettings', 'url', 'categoryDetails', 'categoryProducts', 'allcategoryProducts'));
                } else {
                    abort(404);
                }
            }
        }
    }


    public function vendorListing($vendorid)
    {
        $appsettings = AppSetting::all()->toArray();
        $cms_pages = CmsPage::get()->toArray();

        // $getVendorShop = Vendor::getVendorShop($vendorid);
        $allvendor = Vendor::with('vendorbusinessdetails', 'adminvendor')->where('id', $vendorid)->first();
        // dd($allvendor);

        $vendorProducts = Product::with('brand')->where('vendor_id', $vendorid)->where('status', 1);
        $vendorProducts = $vendorProducts->paginate(0);
        // dd($vendorProducts);
        return view('NewFrontEndPage.vendor_listing', compact('cms_pages', 'allvendor', 'vendorProducts', 'appsettings'));
    }




    public function detail($id)
    {
        try {
            $shareComponent = \Share::page(
                'https://www.positronx.io/create-autocomplete-search-in-laravel-with-typeahead-js/',
                'Your share text comes here',
            )
                ->facebook()
                ->twitter()
                ->linkedin()
                ->telegram()
                ->whatsapp()
                ->reddit();

            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $productDetails = Product::with(['group', 'category', 'brand', 'images', 'vendor', 'attributes' => function ($query) {
                $query->where('stock', '>', 0)->where('status', 1);
            }])->find($id)->toArray();

            $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
            $totalStock = ProductAttribute::where('product_id', $id)->sum('stock');

            $similarProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->where('id', '!=', $id)->limit(6)->inRandomOrder()->get()->toArray();

            if (empty(Session::get('session_id'))) {
                $session_id = md5(uniqid(rand(), true));
            } else {
                $session_id = Session::get('session_id');
            }
            Session::put('session_id', $session_id);

            $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id' => $id, 'session_id' => $session_id])->count();

            if ($countRecentlyViewedProducts == 0) {
                DB::table('recently_viewed_products')->insert(['product_id' => $id, 'session_id' => $session_id]);
            }
            //Get Recently Viewed Products ids
            $recentProductIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id', '!=', $id)->where('session_id', $session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
            //Get Recently Viewed Products
            $recentlyViewedProducts = Product::with('brand')->whereIn('id', $recentProductIds)->get()->toArray();
            //  dd($recentlyViewedProducts);
            //get group products (Product Colors)
            $groupProducts = array();
            if (!empty($productDetails['product_color'])) {
                $groupProducts = Product::select('id', 'product_image')->where('id', '!=', $id)->where(['product_color' => $productDetails['product_color'], 'status' => 1])->get()->toArray();
                //   dd($groupProducts);
            }
            //get all Rating of product
            $ratings = Rating::with('user')->where('status', 1)->where('product_id', $id)->orderBy('id', 'desc')->get()->toArray();

            //get Average Rating of Product
            $ratingsSum = Rating::where('status', 1)->where('product_id', $id)->sum('rating');
            $ratingsCount = Rating::where('status', 1)->where('product_id', $id)->count();
            if ($ratingsCount > 0) {
                $avgRating = round($ratingsSum / $ratingsCount, 2);
                $avgStarRating = round($ratingsSum / $ratingsCount);
            } else {
                $avgRating = 0;
                $avgStarRating = 0;
            }
            return view('products.product_detail', compact('shareComponent', 'cms_pages', 'appsettings', 'avgRating', 'avgStarRating', 'ratings', 'productDetails', 'categoryDetails', 'similarProducts', 'recentlyViewedProducts', 'totalStock', 'groupProducts'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);
            return $getDiscountAttributePrice;

        }
    }

    public function cartAdd(Request $request)
    {
        // try {


            $data = $request->all();
            $this->validate($request, [
                'size'=>'required',
            ]);

            //Forget the coupon sessions
            Session::forget('couponAmount');
            Session::forget('couponCode');
            if ($data['quantity'] <= 0) {
                $data['quantity'] = 1;
            }

            $getProductStock = ProductAttribute::isStokAvailable($data['product_id'], $data['size']);
            if ($getProductStock < $data['quantity']) {
                return redirect()->back()->with('error_message', 'Required Quantity is not available!');
            }
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => $user_id])->count();
            } else {
                $user_id = 0;
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => $session_id])->count();
            }

            $item = new Cart();
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();

            Alert::toast('Product has been added in your cart! <a href="/cart">View Cart</a>', 'success');
            return redirect()->back();
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Laravel's built-in validation exception
        //     return redirect()->back()->withErrors($e->validator->errors())->withInput();
        // } catch (\Exception $e) {
        //     // Log or handle the exception as needed
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    public function cart()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            $getCartItems = Cart::getCartItems();
            //  dd($getCartItems);

            return view('NewFrontEndPage.products.cart', compact('cms_pages', 'getCartItems', 'appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function cartUpdate(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $request->all();
                // echo "<pre>";print_r($data); die;
                //Forget the coupon sessions
                Session::forget('couponAmount');
                Session::forget('couponCode');
                //get cart details
                $cartDetails = Cart::find($data['cartid']);
                //get Available Product Stock
                $availableStock = ProductAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size']])->first()->toArray();
                // echo "<pre>"; print_r($availableStock); die;

                if ($data['qty'] > $availableStock['stock']) {
                    $getCartItems = Cart::getCartItems();
                    return response()->json([
                        'status' => false,
                        'message' => 'Product Stock is not available',
                        'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems'))
                    ]);
                }

                //get Available Product size is available
                $avaliableSize = ProductAttribute::where(['product_id' => $cartDetails['product_id'], 'size' => $cartDetails['size'], 'status' => 1])->count();
                // echo "<pre>"; print_r($availableStock); die;

                if ($avaliableSize == 0) {
                    $getCartItems = Cart::getCartItems();
                    return response()->json([
                        'status' => false,
                        'message' => 'Product Size is not available. Please remove this product and choose another one!',
                        'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems'))
                    ]);
                }

                Cart::where('id', $data['cartid'])->update(['quantity' => $data['qty']]);
                $getCartItems = Cart::getCartItems();
                 $totalCartItems=Helper::totalCartItems();
                Session::forget('couponAmount');
                Session::forget('couponCode');
                return response()->json([
                    'status' => true,
                    'totalCartItems' => $totalCartItems,
                    'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems')),
                    'headerview' => (string)View::make('fontend.layout.min_cart')->with(compact('getCartItems'))
                ]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function cartDelete(Request $request)
    {
        try {
            if ($request->ajax()) {
                Session::forget('couponAmount');
                Session::forget('couponCode');
                $data = $request->all();
                //Forget the coupon sessions
                Session::forget('couponAmount');
                Session::forget('couponCode');
                Cart::where('id', $data['cartid'])->delete();
                $getCartItems = Cart::getCartItems();
                 $totalCartItems=Helper::totalCartItems();

                return response()->json([
                    'totalCartItems' => $totalCartItems, 'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems')),
                    'headerview' => (string)View::make('fontend.layout.min_cart')->with(compact('getCartItems'))
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function applyCoupon(Request $request)
    {
        // try {
            if ($request->ajax()) {
                $data = $request->all();
                // dd($data);
                Session::forget('couponAmount');
                Session::forget('couponCode');
                $getCartItems = Cart::getCartItems();
                // dd($getCartItems);
                // echo "<pre>";print_r($getCartItems); die;

                 $totalCartItems=Helper::totalCartItems();
                $couponCount = Coupon::where('coupon_code', $data['code'])->count();
                if ($couponCount == 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'The coupon is not valid',
                        'totalCartItems' => $totalCartItems, 'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems')),
                        'headerview' => (string)View::make('fontend.layout.min_cart')->with(compact('getCartItems'))
                    ]);
                } else {
                    //  echo "Check for other coupon conditions";die;
                    //get coupon details
                    $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                    //Check if coupon is active
                    if ($couponDetails->status == 0) {
                        $message = "The coupon is not active";
                    }

                    //Check if coupon is expired
                    $expiry_date = $couponDetails->expiry_date;
                    $current_date = date('Y-m-d');
                    if ($expiry_date < $current_date) {
                        $message = "The coupon is expired!";
                    }
                    //Check if coupon is for single time
                    if ($couponDetails->coupon_type == "Single Time") {

                        $couponCount = Order::where(['coupon_code' => $data['code'], 'user_id' => Auth::user()->id])->count();

                        if ($couponCount >= 1) {
                            $message = "This coupon code is already availed by you";
                        }
                    }

                    //Check if coupon is from selected categories
                    //Get all selected categories from coupon
                    $catArr = explode(",", $couponDetails->categories);

                    $total_amount = 0;
                    foreach ($getCartItems as $key => $item) {
                        if (!in_array($item['product']['category_id'], $catArr)) {
                            $message = "This coupon code is not for one of the selected products.";
                        }
                        $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                        // echo "<pre>";print _r($attrPrice);die;
                        $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                    }

                    //check if coupon is from selected users
                    if (isset($couponDetails->users) && !empty($couponDetails->users)) {
                        $userArr = explode(",", $couponDetails->users);
                        //Get user Id's of all selected users
                        // echo "<pre>";print_r($userArr);die;
                        if (count($userArr)) {
                            foreach ($userArr as $key => $user) {
                                $getUserId = User::select('id')->where('email', $user)->first()->toArray();
                                $usersId[] = $getUserId['id'];
                            }
                            //Check if any Cart item not belong to coupon user
                            foreach ($getCartItems as $item) {
                                if (!in_array($item['user_id'], $usersId)) {
                                    $message = "This coupon code is not for for you. Try with valid coupon code!";
                                }
                            }
                        }
                    }



                    if ($couponDetails->vendor_id > 0) {
                        $productIds = Product::select('id')->where('vendor_id', $couponDetails->vendor_id)->pluck('id')->toArray();
                        foreach ($getCartItems as $item) {
                            if (!in_array($item['product']['id'], $productIds)) {
                                $message = "This coupon code is not for for you. Try with valid coupon code (vendor validation)!";
                            }
                        }
                    }
                    //if error message is there
                    if (isset($message)) {
                        return response()->json([
                            'status' => false,
                            'message' => $message,
                            'totalCartItems' => $totalCartItems, 'view' => (string)View::make('Restaurant.frontend.cart.cart_item')->with(compact('getCartItems')),
                            'headerview' => (string)View::make('fontend.layout.min_cart')->with(compact('getCartItems'))
                        ]);
                    } else {
                        //Check if Coupon Amount type is Fixed or Percantage
                        if ($couponDetails->amount_type == "Fixed") {
                            $couponAmount = $couponDetails->amount;
                        } else {
                            $couponAmount = $total_amount * ($couponDetails->amount / 100);
                        }
                        $grand_total = $total_amount - $couponAmount;
                        //Add coupon code and amount is session variables
                        Session::put('couponAmount', $couponAmount);
                        Session::put('couponCode', $data['code']);
                        $message = "Coupon Code successfully applied. You are availing discount!";

                        return response()->json([
                            'status' => true,
                            'message' => $message,
                            'totalCartItems' => $totalCartItems,
                            'couponAmount' => $couponAmount,
                            'grand_total' => $grand_total,
                            'view' => (string)View::make('Restaurant.frontend.cart.cart_item')
                                ->with(compact('getCartItems')),
                            'headerview' => (string)View::make('fontend.layout.min_cart')->with(compact('getCartItems'))
                        ]);
                    }
                }
            }
        // } catch (\Exception $e) {
        //     // Log or handle the exception as needed
        //     Alert::toast('something is wrong!!', 'error');
        //     return redirect()->back();
        // }
    }

    public function checkout(Request $request)
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $countries = Country::where('status', 1)->get()->toArray();
            $getCartItems = Cart::getCartItems();

            if (count($getCartItems) == 0) {
                Alert::toast('Shopping Cart is empty! Please add products to checkout', 'error');
                return redirect('cart');
            }
            $total_price = 0;
            $total_weight = 0;
            $totalTax = 0;

            foreach ($getCartItems as $item) {
                // Get product details
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $product_price = $getDiscountAttributePrice['final_price'];
                $product_quantity = $item['quantity'];

                // Calculate product total price without discount
                $product_total_price = $product_price * $product_quantity;

                // Get product weight and calculate total weight
                $product_weight = $item['product']['product_weight'];
                $total_weight += $product_weight;

                // Apply discount based on quantity
                $discount = Discount::where('product_id',$item['product_id'])
                    ->where('min_product', '<=', $product_quantity)
                    ->where('max_product', '>=', $product_quantity)
                    ->where('status',1)
                    ->first();


                if ($discount){
                    if($discount->discount_type==="Discounted Price"){
                        // dd("price");
                        $product_total_price_after_discount = $product_total_price - $discount->amount;
                    }
                    if($discount->discount_type==="Percentage"){
                            // dd("%");
                            $discountAmount = $product_total_price * ($discount->amount / 100);
                            // dd($discountAmount);
                            $product_total_price_after_discount = $product_total_price - $discountAmount;
                    }
                } else {
                    $product_total_price_after_discount = $product_total_price;
                }

                // Add discounted price to total price
                $total_price += $product_total_price_after_discount;

                // Calculate tax
                $get_tax_percent = Product::select('product_tax')->where('id', $item['product_id'])->first();
                $tax_percent = $get_tax_percent->product_tax;
                $tax_amount = round($product_total_price_after_discount * $tax_percent / 100, 2);

                // Add tax to total tax
                $totalTax += $tax_amount;
            }
            // dd($total_price);

            // foreach ($getCartItems as $item) {
            //     // echo "<pre>"; print_r($item); die;
            //     $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
            //     $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']);
            //     $product_weight = $item['product']['product_weight'];
            //     $total_weight = $total_weight + $product_weight;

            //     $product_total_price = $getDiscountAttributePrice['final_price'] * $item['quantity'];
            //     $get_tax_percent = Product::select('product_tax')->where('id', $item['product_id'])->first();

            //     $taxpercent = $get_tax_percent->product_tax;
            //     $getAmount = round($product_total_price * $taxpercent / 100, 2);
            //     $totalTax = $totalTax + $getAmount;
            // }

            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            foreach ($deliveryAddresses as $key => $value) {
                $shippingCharges = ShippingCharge::getShippingCharges($total_weight, $value['city']);
                $deliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
                $deliveryAddresses[$key]['producttax'] = $totalTax;
            }
            // dd($deliveryAddresses);

            if ($request->isMethod('post')) {
                $data = $request->all();

                //Website Security
                foreach ($getCartItems as $item) {
                    $product_status = Product::getProductStatus($item['product_id']);
                    if ($product_status == 0) {

                        Alert::toast($item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.", 'error');

                        return redirect('/cart');
                    }
                    //prvent sold out product to order
                    $getProductStock = ProductAttribute::isStokAvailable($item['product_id'], $item['size']);
                    if ($getProductStock == 0) {
                        // Product::deleteCartProduct($item['product_id']);
                        // notify()->error('One of the product is sold out!','Please try again');
                        Alert::toast($item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.", 'error');
                        return redirect('/cart');
                    }
                    //Prevent Disabled out ProductAttributes to Order
                    $getAttributeStatus = ProductAttribute::getAttributeStatus($item['product_id'], $item['size']);
                    if ($getAttributeStatus == 0) {
                        // Product::deleteCartProduct($item['product_id']);
                        // notify()->error('One of the product attribute is sold out!','Please try again');
                        Alert::toast($item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.", 'error');
                        return redirect('/cart');
                    }
                    //Prevent disabled Categories product to order
                    $getCategoryStatus = Category::getCategoryStatus($item['product']['category_id']);
                    if ($getCategoryStatus == 0) {
                        // Product::deleteCartProduct($item['product_id']);
                        // notify()->error('One of the product category is disabled!','Please try again');
                        Alert::toast($item['product']['product_name'] . " with " . $item['size'] . " Size is not available. Please remove from cart and choose some other product.", 'error');
                        return redirect('/cart');
                    }
                }
                //check validation for address_id
                if (empty($data['address_id'])) {

                    Alert::toast('Please select Delivery Address!', 'error');
                    return redirect()->back();
                }
                //check validation for payment getway
                if (empty($data['payment_gateway'])) {
                    Alert::toast('Please select Payment Geteway!', 'error');
                    return redirect()->back();
                }
                //agree to T&C validation

                if (empty($data['accept'])) {

                    Alert::toast('Please agree to T&C!', 'error');
                    return redirect()->back();
                }
                $deliveryAddresses = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();
                // dd($deliveryAddresses);

                //Set Payment Method as COD if COD is selected from user otherwise set as Prepaid
                if ($data['payment_gateway'] == "COD") {
                    $payment_method = "COD";
                    $order_status = "New";
                } elseif ($data['payment_gateway'] == "Chapa") {
                    $payment_method = "Chapa";
                    $order_status = "Pending";
                } else {
                    $payment_method = "Paypal";
                    $order_status = "Pending";
                }

                DB::beginTransaction();

                //Calculate Shipping Charges
                $shipping_charges = 0;

                //get shipping charges
                $shipping_charges = ShippingCharge::getShippingCharges($total_weight, $deliveryAddresses['city']);

                //Calculate Grand Total
                $grand_total = $total_price + $shipping_charges + $totalTax - Session::get('couponAmount');

                $grand_total = $grand_total;

                $grand_total=  Helper::final_amount_currency_converter($grand_total);

                $get_currency=Session::get('currency_code');

                Session::put('grand_total', $grand_total);

                //Insert Order Details
                $user_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->order_code = $user_code;
                $order->name = $deliveryAddresses['name'];
                $order->address = $deliveryAddresses['address'];
                $order->city = $deliveryAddresses['city'];
                $order->state = $deliveryAddresses['state'];
                $order->country = $deliveryAddresses['country'];
                $order->pincode = $deliveryAddresses['pincode'];
                $order->mobile = $deliveryAddresses['mobile'];
                $order->email = Auth::user()->email;
                $order->shipping_charges = $shipping_charges;
                $order->tax_charge = $totalTax;
                $order->coupon_code = Session::get('couponCode');
                $order->coupon_amount = Session::get('couponAmount');
                $order->order_status = $order_status;
                $order->payment_method = $payment_method;
                $order->payment_gateway = $data['payment_gateway'];
                $order->grand_total = $grand_total;
                $order->save();

                $order_id = DB::getPdo()->lastInsertId();
                foreach ($getCartItems as $item) {
                    $cartItem = new OrderProduct();
                    $cartItem->order_id = $order_id;
                    $cartItem->user_id = Auth::user()->id;
                    $getProductDetails = Product::select('product_code', 'product_name', 'product_color', 'admin_id', 'vendor_id')->where('id', $item['product_id'])->first()->toArray();
                    //  dd($getProductDetails);
                    $vendor_code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

                    $cartItem->admin_id = $getProductDetails['admin_id'];
                    $cartItem->vendor_id = $getProductDetails['vendor_id'];
                    $cartItem->order_product_code = $vendor_code;
                    $cartItem->product_id = $item['product_id'];
                    $cartItem->product_code = $getProductDetails['product_code'];
                    $cartItem->product_name = $getProductDetails['product_name'];
                    $cartItem->product_color = $getProductDetails['product_color'];
                    $cartItem->product_size = $item['size'];

                    $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                    $discount = Discount::where('product_id',$item['product_id'])
                    ->where('min_product', '<=', $product_quantity)
                    ->where('max_product', '>=', $product_quantity)
                    ->where('status',1)
                    ->first();

                     $total_prices=0;
                     $product_total_price=$getDiscountAttributePrice['final_price'];
                      //for commication
                     $product_total_price_for_commication = $product_total_price;
                     $total_item_price = $product_total_price_for_commication * $item['quantity'];

                    if ($discount){
                        if($discount->discount_type==="Discounted Price"){
                            $product_total_price_after_discount = $product_total_price - $discount->amount;
                        }
                        if($discount->discount_type==="Percentage"){
                                $discountAmount = $product_total_price * ($discount->amount / 100);
                                $product_total_price_after_discount = $product_total_price - $discountAmount;
                        }
                    }
                    // Add discounted price to total price
                    $total_prices += $product_total_price_after_discount;

                    if($discount){
                        $cartItem->discounted_price= $total_prices;
                    }

                    // dd($item);
                    $cartItem->product_price = $product_total_price;
                    $cartItem->product_qty = $item['quantity'];

                    if($discount){
                    $cartItem->discount_type= $discount->discount_type;
                    $cartItem->specail_discount = $discount->amount;
                    }
                    $cartItem->save();
                    //Reduce Stock Script Starts
                    $getProductStock = ProductAttribute::isStokAvailable($item['product_id'], $item['size']);
                    $newStock = $getProductStock - $item['quantity'];
                    ProductAttribute::where(['product_id' => $item['product_id'], 'size' => $item['size']])->update(['stock' => $newStock]);

                     // Calculate and save commission for each item if referral token exists
                    if (Session::has('referral_token')) {
                        $commission_amount=SalesMainCommission::first();
                        $token = Session::get('referral_token');
                        $commissionAmount = $total_item_price * ($commission_amount->commission_amount / 100);
                        $commission = new SalesCommission();
                        $commission->salesperson_id = SalesCommission::getSalespersonIdFromToken($token);
                        $commission->order_id = $order_id;
                        $commission->product_id = $item['product_id'];
                        $commission->amount = $commissionAmount;
                        $commission->save();
                    }
                }

                Session::forget('referral_token');

                //insert order Id in Session variable
                Session::put('order_id', $order_id);

                DB::commit();
                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

                if ($data['payment_gateway'] == "COD") {

                    // $email = Auth::user()->email;
                    // $email_template = EmailTemplate::first();
                    // $messageData = [
                    //     'email_template' => $email_template,
                    //     'email' => $email,
                    //     'name' => Auth::user()->name,
                    //     'order_id' => $order_id,
                    //     'orderDetails' => $orderDetails
                    // ];
                    // Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    //     $message->to($email)->subject('Order Placed');
                    // });
                }
                if ($data['payment_gateway'] == "Chapa") {
                    return redirect()->route('chapa', compact('appsettings'));
                }
                if ($data['payment_gateway'] == "Paypal") {
                    return redirect()->route('paypal', compact('appsettings'));
                }
                //  else
                // {
                // echo "Prepaid payment method coming soon";
                // }
                Alert::toast('Order successfully placed!', 'success');
                return redirect()->route('thanks', compact('appsettings'));
            }

            $total_price = 0;
            foreach ($getCartItems as $item) {
                $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']);
                $city = ShippingCharge::all()->where('status', 1);
                $state = State::all()->where('status', 1);
            }

            return view('NewFrontEndPage.delivery_address.checkout', compact('city', 'state', 'appsettings', 'cms_pages', 'deliveryAddresses', 'countries', 'getCartItems', 'total_price', 'totalTax'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function thanks()
    {
        try {
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            if (Session::has('order_id')) {
                Cart::where('user_id', Auth::user()->id)->delete();
                return view('NewFrontEndPage.COD.thanks', compact('appsettings', 'cms_pages'));
            } else {
                return redirect('cart', compact('appsettings', 'cms_pages'));
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function updateWhishlist(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $request->all();
                $countWishlist = Wishlist::countWishlist($data['product_id']);
                if ($countWishlist == 0) {
                    $wishlist = new Wishlist;
                    $wishlist->user_id = Auth::user()->id;
                    $wishlist->product_id = $data['product_id'];
                    $wishlist->save();
                    return response()->json(['status' => true, 'action' => 'add']);
                } else {
                    Wishlist::where(['user_id' => Auth::user()->id, 'product_id' => $data['product_id']])->delete();
                    return response()->json(['status' => true, 'action' => 'remove']);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function wishlist()
    {
        try {
            $userWishlistItems = Wishlist::userWishlistItems();
            $meta_title = "Wish List BYT Multivendor Ecommerece Website";
            $meta_description = "View Wish List of BYT Multivendor Ecommerce Website";
            $meta_keywords = "wish list, BYT Multivendor Ecommerce Website";
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();
            return view('NewFrontEndPage.products.wishlilst', compact('userWishlistItems', 'meta_description', 'meta_keywords', 'meta_keywords', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function deleteWishlistItem(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $request->all();
                Wishlist::where('id', $data['wishlistid'])->delete();

                $userWishlistItems = Wishlist::userWishlistItems();
                $totalWishlistItems = Helper::totalWishlistItems();
                return response()->json([
                    'totalWishlistItems' => $totalWishlistItems,
                    'view' => (string)View::make('NewFrontEndPage.products.wishlist_items')->with(compact('userWishlistItems'))
                ]);
            }
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function OfferProductOrder(Request $request)
    {
        // Validate the request data
        $request->validate([
            'quantity' => 'required|integer',
            'size' => 'required|string|max:255',
            'description' => 'required|string',
            'offer_price' => 'required|numeric',
        ]);

        $offer=new Offer();
        $offer->product_id=$request->input('product_id');
        $offer->user_id=$request->input('user_id');
        $offer->quantity=$request->quantity;
        $offer->size=$request->description;
        $offer->description=$request->description;
        $offer->offer_price=$request->offer_price;
        $offer->save();

        Alert::toast('Product offer submited successfully','success');
        return redirect()->back();
    }

}