<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TipSettingsController extends Controller
{
    //
    public function index() {
        $tips = Tip::paginate(10);
        return view('admin.tip.index', compact('tips'));
    }

    public function store(Request $request) {
        $request->validate(['amount' => 'required|numeric|min:0']);
        Tip::create(['amount' => $request->amount]);
         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Tip', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return back()->with('success', 'Tip added!');
        
    }

    public function update(Request $request, Tip $tip) {
        $request->validate(['amount' => 'required|numeric|min:0']);
        $tip->update(['amount' => $request->amount]);

         $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Update Tip', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return back()->with('success', 'Tip updated!');
    }

    public function destroy(Tip $tip) {
        $tip->delete();
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Delete Tip', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");

        return back()->with('success', 'Tip deleted!');
    }
}