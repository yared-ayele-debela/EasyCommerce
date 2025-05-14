<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;

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
        return back()->with('success', 'Tip added!');
    }

    public function update(Request $request, Tip $tip) {
        $request->validate(['amount' => 'required|numeric|min:0']);
        $tip->update(['amount' => $request->amount]);
        return back()->with('success', 'Tip updated!');
    }

    public function destroy(Tip $tip) {
        $tip->delete();
        return back()->with('success', 'Tip deleted!');
    }
}
