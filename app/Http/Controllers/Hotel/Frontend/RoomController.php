<?php

namespace App\Http\Controllers\Hotel\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    //
    public function index($id){
        
        $room=Room::with('images','amenities')->findOrFail($id);
        return view('Hotel.frontend.pages.room.detail',compact('room'));
    }

   
}