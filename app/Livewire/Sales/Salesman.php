<?php

namespace App\Livewire\Sales;

use App\Models\SalesMainCommission;
use App\Models\SalesUser;
use App\Services\ActivityLogger;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Salesman extends Component
{

    use WithFileUploads;

    public $salesUsers,$salesUsersCommission, $name, $image, $phone, $address, $referral_token, $email, $password, $salesUserId,$currentImage;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $CommissionModalOpen = false;

    // for commission
    public $commission_amount;


    public function generateToken($id)
    {
        $salesperson = SalesUser::findOrFail($id);
        if($salesperson->status==0){
            session()->flash('error',  'Active user before generate token!.');
            $this->closeModal();
            $this->resetInputFields();
            return;
        }
        $salesperson->generateReferralToken();
        session()->flash('message',  'Referral token generated successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }


    public function render()
    {
        $this->salesUsers = SalesUser::all();
        $this->salesUsersCommission=SalesMainCommission::first();

        return view('livewire.sales.salesman');
    }

    public function add_commission(){
        $this->CommissionModalOpen();
    }

    public function store_commission()
    {
        $this->validate([
            'commission_amount' => 'required|numeric',
        ]);

        $commission = SalesMainCommission::first();

        if ($commission) {
            $com = SalesMainCommission::findOrFail($commission->id);
            $com->commission_amount = $this->commission_amount;
            $com->save(); // Use save() to update existing record
            session()->flash('message', 'Sales Commission updated successfully.');
        } else {
            $com = new SalesMainCommission();
            $com->commission_amount = $this->commission_amount;
            $com->save(); // Use save() to create a new record
            session()->flash('message', 'Sales Commission saved successfully.');
        }

        $this->closeModal(); // Close the modal after submission
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function CommissionModalOpen()
    {
        $this->CommissionModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDeleteModalOpen = false;
        $this->CommissionModalOpen = false;
    }

    public function openDeleteModal($id)
    {
        $this->salesUserId = $id;
        $this->isDeleteModalOpen = true;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->image = '';
        $this->phone = '';
        $this->address = '';
        $this->email = '';
        $this->password = '';
        $this->salesUserId = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'image' => $this->image ? 'nullable':'image|max:1024', // 1MB Max
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:sales_users,email,' . $this->salesUserId,
            'password' => $this->salesUserId ? 'nullable' : 'required',

        ]);

        if ($this->image) {
            $storedPath = $this->image->store('photos', 'public');
            $imageUrl = asset('storage/' . $storedPath);
        } else {
            $imageUrl = $this->image; // fallback if updating without new image
        }

        SalesUser::updateOrCreate(['id' => $this->salesUserId], [
            'name'     => $this->name,
            'image'    => $imageUrl,
            'phone'    => $this->phone,
            'address'  => $this->address,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);
                $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Add Sales Man', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


        session()->flash('message', $this->salesUserId ? 'Sales User Updated Successfully.' : 'Sales User Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $salesUser = SalesUser::findOrFail($id);
        $this->salesUserId = $id;
        $this->name = $salesUser->name;
        $this->image = $salesUser->image;
        $this->phone = $salesUser->phone;
        $this->address = $salesUser->address;
        $this->email = $salesUser->email;
        $this->password = '';
        $this->currentImage = $salesUser->image; // Store current image path

        $this->openModal();
    }


    public function delete($id)
    {
        $this->openDeleteModal($id);
    }

    public function destroyProduct()
    {
        SalesUser::find($this->salesUserId)->delete();
        session()->flash('message', 'Sales User Deleted Successfully.');
        $this->closeModal();
    }

    public function update_status($id){

        $sales_user=SalesUser::findOrFail($id);
        if($sales_user){
            $sales_user->status = $sales_user->status == 1 ? 0 : 1;
            $sales_user->update();
             $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toDateTimeString(); // 'Y-m-d H:i:s'
        ActivityLogger::log( 'Edit Sales Man', Auth::guard('admin')->user()->name . " at {$formattedDateTime}");


            $this->closeModal();
            $this->resetInputFields();
        }
    }

}