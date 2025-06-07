<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function delete($id){

        $notification=Notification::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success','Notification deleted successfully');
    }
}