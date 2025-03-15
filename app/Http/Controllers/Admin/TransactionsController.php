<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionsController extends Controller
{
    public function index(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view transaction')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();

        $transactions=Payment::with('order','user')->get();
        // dd($transactions);

        return view('admin.transactions.index',compact('transactions','appsettings'));
    }
    public function detail($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view detail transaction')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $transaction=Payment::with('order','user')->where('id',$id)->first();
        // dd($transaction);

        return view('admin.transactions.detail',compact('transaction','appsettings'));
    }
    public function update(Request $request){
        // dd($request->all());
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('edit transaction')) {
            return view('admin.errors.unauthorized');
        }

        $transaction=Payment::findOrFail($request->input('id'));
        // dd($transaction);
        $transaction->amount=$request->input('amount');
        $transaction->update();

        Alert::toast('Payment amount has been updated','success');
        return redirect()->back();
    }
    public function delete($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete transaction')) {
            return view('admin.errors.unauthorized');
        }
        $transaction=Payment::findOrFail($id);
        // dd($transaction);
        $transaction->delete();

        Alert::toast('Payment has been deleted','info');
        return redirect()->back();
    }
}
