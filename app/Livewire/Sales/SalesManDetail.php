<?php

namespace App\Livewire\Sales;

use App\Models\SalesCommission;
use App\Models\SalesUser;
use Livewire\Component;

class SalesManDetail extends Component
{
    public $salesUserId;
    public $salesUser;
    public $selesCommision;

    public function mount($id)
    {
        $this->salesUserId = $id;
        $this->salesUser = SalesUser::find($this->salesUserId);
        $this->selesCommision = SalesCommission::with('sales','product','order')->where('salesperson_id',$this->salesUserId)->get();
        // dump($this->selesCommision);
    }


    public function render()
    {
        return view('livewire.sales.sales-man-detail');
    }
}