<?php

namespace App\Livewire\WithdrawRequest;

use App\Models\WithdrawalRequest;
use App\Models\WithdrawSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WithdrawRequest extends Component
{
    public $amount;
    public $requests;

    public function mount()
    {
        $this->requests = WithdrawalRequest::where('vendor_id',Auth::guard('admin')->user()->id)->get();
    }

    public function createRequest()
    {
        $vendor = Auth::guard('admin')->user(); // Assuming the vendor is authenticated
        $minimum_withdrawal_request= WithdrawSetting::first();
        $minimum_amount=$minimum_withdrawal_request->amount;
        $check= $this->amount>$minimum_amount;
        if($check){
            session()->flash('error', 'You need to have at least ' . $minimum_amount . ' in total earnings to request a withdrawal.');
            return;
        }
        $this->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        WithdrawalRequest::create([
            'vendor_id' => $vendor->id,
            'amount' => $this->amount,
        ]);

        $this->requests = WithdrawalRequest::where('vendor_id',Auth::guard('admin')->user()->id)->get();
        $this->amount = null;

        session()->flash('success', 'Withdrawal request created successfully.');
    }


    public function render()
    {
        return view('livewire.withdraw-request.withdraw-request');
    }
}