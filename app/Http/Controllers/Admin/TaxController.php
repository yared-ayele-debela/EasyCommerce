<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\TaxComponent;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    //
    public function index(){

        return view('admin.tax.index')->withComponent(TaxComponent::class);
    }
}