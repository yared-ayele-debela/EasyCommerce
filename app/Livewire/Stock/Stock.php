<?php

namespace App\Livewire\Stock;

use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class Stock extends Component
{
    use WithPagination;


    public $all_stocks;

    public function mount(){

        $this->loadStocks();

    }
    public function loadStocks()
    {
        $this->all_stocks = ProductAttribute::with('product', 'warehouse')->get();
    }

    public function update_status($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_attribute')) {
                return redirect()->back();
            }
            $productattribute = ProductAttribute::find($id);
            $productattribute->status = $productattribute->status == 1 ? 0 : 1;
            $productattribute->update();

            $this->loadStocks();

        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function render()
    {

        return view('livewire.stock.stock',[
            'all_stock'=>$this->all_stocks,
        ]);
    }
}