<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Livewire\WithdrawRequest\WithdrawRequest;
use App\Models\VendorWallet;
use App\Models\VendorWalletTransaction;
use App\Models\VendorWithdrawRequest;
use Illuminate\Http\Request;

class VendorWithdrawRequestController extends Controller
{
    //

    public function index(){

        $requests=VendorWithdrawRequest::with('vendor')->latest()->get();
        return view('admin.vendor.vendor_withdraw_requests.index',compact('requests'));
    }

    public function updateWithdrawStatus(Request $request, $id)
    {
        $withdraw = VendorWithdrawRequest::findOrFail($id);
        $vendorWallet = VendorWallet::where('vendor_id', $withdraw->vendor_id)->first();

        // dd($withdraw);
        if ($request->status == 'approved') {
            $vendorWallet->pending_balance -= $withdraw->amount;
            $vendorWallet->total_withdrawn += $withdraw->amount;

            VendorWalletTransaction::create([
                'vendor_id' => $withdraw->vendor_id,
                'type' => 'debit',
                'amount' => $withdraw->amount,
                'description' => 'Withdrawal approved'
            ]);
        } elseif ($request->status == 'rejected') {
            $vendorWallet->pending_balance -= $withdraw->amount;
            $vendorWallet->available_balance += $withdraw->amount;
        }

        $vendorWallet->save();
        $withdraw->status = $request->status;
        $withdraw->note = $request->note;
        $withdraw->save();

        return back()->with('success', 'Withdrawal status updated');
    }

}