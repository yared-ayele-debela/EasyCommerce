<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    //
    public function index($id){
        try{
            $hotel=Hotel::findOrFail($id);
            $rooms=$hotel->rooms()->latest()->paginate(10);
            
            return view('Hotel.frontend.pages.hotel.detail',compact('hotel','rooms'));  
        }catch(Exception $e){
            return redirect()->back();
        }
        
    }
    public function gallery($id){
        try{
        $hotel=Hotel::findOrFail($id);
        return view('Hotel.frontend.pages.hotel.gallery',compact('hotel'));
    }catch(Exception $e){
        return redirect()->back();
    }
    }

    public function select_date($id){

        $id=decrypt($id);
        $room=Room::with('images','amenities','hotel')->findOrFail($id);
        // dd($room);
        return view('Hotel.frontend.pages.room.select_date',compact('room'));
    }

    public function discounted(){
        
        $hotels=Hotel::with('photos')->where('discount','>','0')->latest()->paginate(10);
        $name="Discounted Hotels";
        // dd($hotels);

        return view('Hotel.frontend.pages.hotel.index',compact('hotels','name'));
    }
    public function latest(){
        
        $hotels=Hotel::with('photos')->latest()->paginate(10);
        $name="Latest Hotels";
        // dd($hotels);

        return view('Hotel.frontend.pages.hotel.index',compact('hotels','name'));
    }
}