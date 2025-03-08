<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table='groups';
    protected  $fillable=[
          'name',
          'description',
          'status'
    ];
    public static function groups(){

      $getgroups=Group::with('categories')->where('status',1)->get()->toArray();
      return $getgroups;
    }

    // public function categories(){

    //   return $this->hasMany('App\Models\Category','id')->with('subcategory');
    // }
    public function categories(){

      return $this->hasMany('App\Models\Category','group_id')->where(['parent_id'=>0,'status'=>1])->with('subcategories');
    }
    
    // public function subcategories(){

    //   return $this->hasMany('App\Models\SubCategory','id');
    // }




}
