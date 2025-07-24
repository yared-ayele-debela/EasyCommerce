<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\ProductAttribute;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table="products";

    use HasFactory;

    protected $fillable = [
        'group_id',
        'category_id',
        'subcategory_id',
        'brand_id',
        'vendor_id',
        'admin_id',
        'admin_type',
        'product_name',
        'product_code',
        'product_color',
        'product_price',
        'quantity',
        'product_selling_price',
        'product_discount',
        'product_weight',
        'product_image',
        'product_video',
        'description',
        'available_for_delivery',
        'is_returnable',
        'returnable_time',
        'is_featured',
        'status',
        'status_comment'
    ];

    public function months()
    {
        return $this->belongsToMany(Month::class,'product_month');
    }


    public function group(){
        return $this->belongsTo('App\Models\Group','group_id');
    }

    public function category(){

        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function brand(){
        return $this->BelongsTo('App\Models\Brand','brand_id');
    }

    // public function subcategory(){

    //     return $this->belongsTo('App\Models\SubCategory','subcategory_id');
    // }
    public function attributes(){

        return $this->hasMany('App\Models\ProductAttribute');
    }
    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorbusinessdetails');
    }
    public function images(){

        return $this->hasMany('App\Models\ProductsImage');
    }


    public static function getDiscountPrice($product_id)
{
    $product = Product::select('product_price', 'product_discount', 'category_id')->find($product_id);

    if (!$product) {
        return null; // or throw an exception
    }

    $price = $product->product_price;
    $productDiscount = $product->product_discount;

    // Use product discount if available
    if ($productDiscount > 0) {
        return round($price - ($price * $productDiscount / 100), 2);
    }

    // Else check category discount
    $category = Category::select('discount')->find($product->category_id);

    if ($category && $category->discount > 0) {
        return round($price - ($price * $category->discount / 100), 2);
    }

    // No discount
    return $price;
}

    public static function getDiscountAttributePrice($product_id,$size)
    {

        $proAttrPrice=ProductAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();

        $proDetails=Product::select('product_discount','category_id')->where('id',$product_id)->first();

        $proDetails=json_decode(json_encode($proDetails),true);
        $catDetails=Category::select('discount')->where('id',$proDetails['category_id'])->first();
        $catDetails=json_decode(json_encode($catDetails),true);


        if($proDetails['product_discount']>0){

            $final_price=$proAttrPrice['price']-($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount=$proAttrPrice['price'] - $final_price;

        }elseif($catDetails['discount']>0){

            $final_price=$proAttrPrice['price']-($proAttrPrice['price']*$catDetails['discount']/100);
            $discount=$proAttrPrice['price'] - $final_price;

        }
        else{
            $final_price=$proAttrPrice['price'];
            $discount=0;
        }
        //  for product detail
        $product_detail_price=Helper::final_amount_currency_converter($proAttrPrice['price']);
        $final_price_product_detail=Helper::final_amount_currency_converter($final_price);
        // dd($final_price_product);
        $discount_product_detail=Helper::final_amount_currency_converter($discount);
        //end for product detail

        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount,'product_detail_price'=>$product_detail_price,'final_price_product_detail'=>$final_price_product_detail, 'discount_product_detail'=>$discount_product_detail);
    }


public static function getDiscountProductPrice($product_id)
        {
            $product = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();

            if (!$product) {
                return null; // or throw exception
            }

            $category = Category::select('discount')->where('id', $product->category_id)->first();

            $original_price = $product->product_price;

            if ($product->product_discount > 0) {
                $final_price = $original_price - ($original_price * $product->product_discount / 100);
                $discount = $original_price - $final_price;
            } elseif ($category && $category->discount > 0) {
                $final_price = $original_price - ($original_price * $category->discount / 100);
                $discount = $original_price - $final_price;
            } else {
                $final_price = $original_price;
                $discount = 0;
            }

            return [
                'product_price' => $original_price,
                'final_price' => $final_price,
                'discount' => $discount,
                'product_detail_price' => Helper::final_amount_currency_converter($original_price),
                'final_price_product_detail' => Helper::final_amount_currency_converter($final_price),
                'discount_product_detail' => Helper::final_amount_currency_converter($discount)
            ];
        }


  public static function getProductStock($product_id){
    $getProductStrok=Product::select('quantity')->where(['id'=>$product_id])->first();
    return $getProductStrok->quantity;
  }
    public static function getProductImage($product_id){
        $getProductImage=Product::select('product_image')->where('id',$product_id)->first()->toArray();
        return $getProductImage['product_image'];
    }

    public static function getProductStatus($product_id){
        $getProductStatus=Product::select('status')->where('id',$product_id)->first();

        return $getProductStatus->status;
    }
    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }
    public static function isProductNew($product_id){
        $productIds= Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
    //   dd($productIds);
        if(in_array($product_id,$productIds)){
            $isProductNew = "Yes";
        }else{
            $isProductNew = "No";
        }
        return $isProductNew;

    }

    public static function productCount($category_id){
        $productCount=Product::where(['category_id'=>$category_id,'status'=>1])->count();
        return $productCount;
    }

    public static function RatingCount($product_id){
        $ratingCount=Rating::where(['product_id'=>$product_id])->count();
        return $ratingCount;
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}