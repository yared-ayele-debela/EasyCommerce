<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    //
    public function index()
    {
        $banks = Bank::latest()->get();
        return view('admin.bank.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
        ]);
        Bank::create($request->all());
        return back()->with('success', 'Bank information added.');
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);
        $bank->update($request->only('bank_name', 'account_number'));
        return back()->with('success', 'Bank information updated.');
    }

    public function destroy($id)
    {
        Bank::findOrFail($id)->delete();
        return back()->with('success', 'Bank information deleted.');
    }
}
