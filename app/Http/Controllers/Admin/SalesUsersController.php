<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Livewire\Sales\Salesman;
use App\Livewire\Sales\SalesManDetail;
use Illuminate\Http\Request;

class SalesUsersController extends Controller
{
    //
    public function index(){

        return view('admin.salesman.index')->withComponent(Salesman::class);
    }

    public function detail($id){

        return view('admin.salesman.detail', ['id' => $id, 'component' => SalesManDetail::class]);
    }
}