<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\VendorBussinessDetails;
class Vendor extends Model

{
    use HasFactory;
    protected $table='vendor';
    protected  $fillable=[
            'name',
            'address',
            'city',
            'state',
            'country',
            'pincode',
            'zone',
            'mobile',
            'email',
            'status',
            'created_at',
            'updated_at',
      ];

      public function wallet()
{
    return $this->hasOne(VendorWallet::class);
}

        public function getProductCount()
        {
            return $this->products()->count();
        }
        public function products()
        {
            return $this->hasMany(Product::class);
        }

        public function vendorBank(){

        return $this->belongsTo('App\Models\VendorBankDetails','id','vendor_id');

        }

        public function vendorbusinessdetails(){
                return $this->belongsTo('App\Models\VendorBussinessDetails','id','vendor_id');
        }

        public function adminvendor(){
                return $this->belongsTo('App\Models\Admin','id','vendor_id');
        }

      public static function getVendorShop($vendorid){
          $getVendorShop=VendorBussinessDetails::select('shop_name')->where('vendor_id',$vendorid)->first();
          if($getVendorShop)
          {
            return $getVendorShop['shop_name'];
          }
           return null;
      }

      public static function getVendorCommission($vendorid){
          $getVendorCommission=Vendor::select('commission')->where('id',$vendorid)->first()->toArray();
          return $getVendorCommission['commission'];
      }

      public function withdrawalRequests()
        {
            return $this->hasMany(WithdrawalRequest::class, 'vendor_id');
        }


}