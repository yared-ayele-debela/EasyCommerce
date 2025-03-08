<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\ProductAttribute;
use App\Models\Transfer_stock_product;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransferRequestController extends Controller
{
    //
    public function index(){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('view transfer request')) {
            return view('admin.errors.unauthorized');
        }
        $appsettings=AppSetting::all()->toArray();
        $transfer_request=TransferRequest::where('status','pending')->get();
        // dd($transfer_request);

        return view('admin.transfer_request.index',compact('transfer_request','appsettings'));
    }

    public function approve($id){
       try{
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('approve transfer request')) {
            return view('admin.errors.unauthorized');
        }
        $approval = TransferRequest::findOrFail($id);
        $approval->status="approved";
        $approval->update();

        $fromWarehouseStock = ProductAttribute::where('product_id', $approval->product_id)
        ->where('warehouse_id',$approval->from_warehouse_id)
        ->where('size', $approval->size)
        ->first();

        $destinationStockProduct = ProductAttribute::firstOrNew([
            'product_id' => $approval->product_id,
            'warehouse_id' => $approval->to_warehouse_id,
            'size' => $approval->size,
            'price' => $approval->price,
            'status' => 1
        ]);

        $fromWarehouseStock->update([
            'stock' => $fromWarehouseStock->stock - $approval->quantity
        ]);

        // Update destination warehouse stock
        if ($destinationStockProduct) {
            $destinationStockProduct->stock += $approval->quantity;;
            $destinationStockProduct->save();
        }

        $stock = new Transfer_stock_product();
        $stock->from_warehouse_id = $approval->from_warehouse_id;
        $stock->to_warehouse_id = $approval->to_warehouse_id;
        $stock->quantity = $approval->quantity;
        $stock->product_id = $approval->product_id;
        $stock->notes = $approval->notes;
        $stock->transfer_date = $approval->transfer_date;
        $stock->shipped_confirmation_number = $approval->shipped_confirmation_number;
        $stock->delivered_confirmation_number = $approval->delivered_confirmation_number;

        $stock->save();

        Alert::toast('Transfer Request Approved!!','success');
        return redirect()->back();
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Laravel's built-in validation exception
        return redirect()->back()->withErrors($e->validator->errors())->withInput();
    } catch (\Exception $e) {
        Alert::toast('something is wrong!!', 'error');
        return redirect()->back();
    }
    }

    public function delete($id){
        $user = Auth::guard('admin')->user();
        if (!$user || !$user->hasPermissionByRole('delete transfer request')) {
            return view('admin.errors.unauthorized');
        }
        $transfer_request=TransferRequest::findOrFail($id);
        if($transfer_request){
            // dd($transfer_request);
            $transfer_request->delete();
        }
        Alert::toast('Transfer Request Deleted!!','error');
        return redirect()->back();
    }


}
