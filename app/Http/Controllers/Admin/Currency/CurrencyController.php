<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CurrencyController extends Controller
{
    //
    public function currencyload(Request $request)
    {
        session()->put('currency_code',$request->currency_code);
        $currency=Currencies::where('code',$request->currency_code)->first();
        session()->put('currency_symbol',$currency->symbol);

        session()->put('currency_exchange_rate',$currency->exchange_rate);
        $response['status']=true;

        return $response;
    }

    public function index(){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('view currency')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings=AppSetting::all()->toArray();
        $all_currency=Currencies::paginate(20);
        return view('admin.currency.index',compact('all_currency','appsettings'));
    }

    public function create(){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('add currency')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings = AppSetting::all()->toArray();
        return view('admin.currency.create',compact('appsettings'));
    }

    public function store(Request $request){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('add currency')) {
            return view('admin.errors.unauthorized');
        }

      if ($request->isMethod('post')) {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        $this->validate($request, [
            'name' => 'required|string|without_spaces',
            'symbol' => 'required',
            'exchange_rate' => 'required|numeric',
            'code'=>'required|without_spaces'
        ]);

        // dd($request->all());
        $currency = new Currencies();
        $currency->name=$request->input('name');
        $currency->symbol=$request->input('symbol');
        $currency->exchange_rate=$request->input('exchange_rate');
        $currency->code=$request->input('code');
        $currency->save();

        Alert::toast('Currency has been saved','success');
        return redirect()->route('currencies');

      }else{
        abort(403,'Unauthorized Access!');
      }
    }

    public function edit($id){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('edit currency')) {
            return view('admin.errors.unauthorized');
        }

        $appsettings = AppSetting::all()->toArray();
        $currency=Currencies::findOrFail($id);
        if($currency){
            return view('admin.currency.edit',compact('currency','appsettings'));
        }else{
            Alert::toast('Invalid Request','error');
            return redirect()->back();
        }
    }
    public function update(Request $request){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('edit currency')) {
            return view('admin.errors.unauthorized');
        }

        if ($request->isMethod('put')) {
            Validator::extend('without_spaces', function($attr, $value){
                return preg_match('/^\S*$/u', $value);
            });
            $this->validate($request, [
                'name' => 'required|string|without_spaces',
                'symbol' => 'required',
                'exchange_rate' => 'required|numeric',
                'code'=>'required|without_spaces'
            ]);

            // dd($request->all());
            $currency = Currencies::findOrFail($request->input('id'));
            $currency->name=$request->input('name');
            $currency->symbol=$request->input('symbol');
            $currency->exchange_rate=$request->input('exchange_rate');
            $currency->code=$request->input('code');
            $currency->update();

            Alert::toast('Currency has been updated','success');
            return redirect()->route('currencies');

          }else{
            abort(403,'Unauthorized Access!');
          }

    }

    public function delete($id){
        $user = Auth::guard('admin')->user();

        if (!$user || !$user->hasPermissionByRole('delete currency')) {
            return view('admin.errors.unauthorized');
        }

        $data = Currencies::where('id',$id)->first();
        if($data){
            $data->delete();
        }
        Alert::toast('Currency has been deleted','info');
        return redirect()->back();
    }

}
