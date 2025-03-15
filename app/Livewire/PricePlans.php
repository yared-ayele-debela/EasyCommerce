<?php

namespace App\Livewire;

use App\Models\PricePlan;
use Livewire\Component;

class PricePlans extends Component
{
    public $pricePlans, $name, $description, $price, $status, $duration, $pricePlanId, $pricePlanID,$selectedPricePlan;
    public $isModalOpen = 0;

    public function mount()
    {
        $this->resetInputFields();
        $this->pricePlans = PricePlan::all();
    }
    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->status = 0;
        $this->duration = '';
        $this->pricePlanId = null;
    }


    public function closeModal()
    {
        $this->resetInputFields();
    }


    public function render()
    {
        return view('livewire.price-plans');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration' => 'required|string',
        ]);

        PricePlan::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
        ]);

        session()->flash('message','Price Plan Saved Successfully.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
        $this->mount();

    }


    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration' => 'required|string',
        ]);

        $this->selectedPricePlan->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
        ]);

        session()->flash('message','Price Plan Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
        $this->mount();
    }

    public function edit($id)
    {
        $this->selectedPricePlan = PricePlan::findOrFail($id);
        $this->pricePlanId = $id;
        $this->name = $this->selectedPricePlan->name;
        $this->description = $this->selectedPricePlan->description;
        $this->price = $this->selectedPricePlan->price;
        $this->duration = $this->selectedPricePlan->duration;

    }

    public function deletePricePlan(int $id)
    {
        $this->pricePlanID = $id;
    }

    public function destroyPricePlan()
    {
        PricePlan::findOrFail($this->pricePlanID)->delete();
        session()->flash('message','Price Plan Deleted Successfully');
        $this->dispatch('close-modal');
        $this->mount();
    }

    public function update_status($id){
        $discount= PricePlan::find($id);
        $discount->status = $discount->status == 1 ? 0 : 1;
        $discount->update();
        $this->mount();

    }
}