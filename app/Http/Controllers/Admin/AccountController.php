<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //

    public function adminList()
    {
        $requests = AccountDeletionRequest::where('is_reviewed', false)->get();
        $request_history= AccountDeletionRequest::where('is_reviewed', true)->get();
        return view('admin.account_delete_request.index', compact('requests', 'request_history'));
    }

    // Admin action: Approve and delete
    public function deleteUser($requestId)
    {
        $request = AccountDeletionRequest::findOrFail($requestId);
        $user=User::where('email', $request->user_email)->where('mobile',$request->user_phone)->first();
        if ($user) {
            $user->delete();
        }else{
            // dd(false);
            return back()->with('error', 'User not found.');
        }

        $request->update(['is_reviewed' => true]);

        return back()->with('message', 'User account has been deleted.');
    }

    // Optional: Reject deletion (mark reviewed only)
    public function rejectRequest($requestId)
    {
        $request = AccountDeletionRequest::findOrFail($requestId);
        $request->update(['is_reviewed' => true]);

        return back()->with('message', 'Request marked as reviewed.');
    }
}