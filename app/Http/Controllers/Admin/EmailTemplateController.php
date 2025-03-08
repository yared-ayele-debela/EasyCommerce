<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EmailTemplateController extends Controller
{
    //
    public function index()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view email template')) {
                return view('admin.errors.unauthorized');
            }
            $emailtemplate = EmailTemplate::paginate(10);
            $appsettings = AppSetting::all()->toArray();
            $emailtemplates = EmailTemplate::count();
            return view('admin.email_template.index', compact('emailtemplate', 'emailtemplates', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add email template')) {
                return view('admin.errors.unauthorized');
            }
            $appsettings = AppSetting::all()->toArray();
            return view('admin.email_template.create', compact('appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('add email template')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('post')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $emailtemplate = EmailTemplate::count();

            if ($emailtemplate >= 1) {
                Alert::toast('You cannot add another email template. Delete the existing one first.', 'error');
                return redirect()->route('email_templates');
            }

            $request->validate([
                'name' => 'required|unique:email_templates', // assuming 'cities' was a mistake and it should be 'email_templates'
                'email' => 'required'
            ]);

            $emailTemplate = new EmailTemplate();
            $emailTemplate->name = $request->input('name');
            $emailTemplate->email = $request->input('email');
            $emailTemplate->phone = $request->input('phone');
            $emailTemplate->address = $request->input('address');
            $emailTemplate->status = 1;
            $emailTemplate->save();

            Alert::toast('Email Template has been saved successfully!', 'success');
            return redirect()->route('email_templates');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit email template')) {
                return view('admin.errors.unauthorized');
            }
            $emailtemplate = EmailTemplate::find($id);
            if (!$emailtemplate) {
                Alert::toast('Email Template not found!', 'error');
                return redirect()->route('email_templates');
            }

            $appsettings = AppSetting::all()->toArray();
            return view('admin.email_template.edit', compact('emailtemplate', 'appsettings'));
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit email template')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->isMethod('put')) {
                // Handle the error - Method not allowed
                Alert::toast('Method not allowed', 'error');
                return redirect()->back();
            }
            $request->validate([
                'name' => 'required|unique:email_templates,name,' . $request->input('id')
            ]);

            $EmailTemplate = EmailTemplate::find($request->input('id'));
            if (!$EmailTemplate) {
                Alert::toast('Email Template not found!', 'error');
                return redirect()->route('email_templates');
            }

            $EmailTemplate->name = $request->input('name');
            $EmailTemplate->email = $request->input('email');
            $EmailTemplate->phone = $request->input('phone');
            $EmailTemplate->address = $request->input('address');
            $EmailTemplate->status = 1;
            $EmailTemplate->save();

            Alert::toast('Email Template has been updated successfully!', 'success');
            return redirect()->route('email_templates');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete email template')) {
                return view('admin.errors.unauthorized');
            }
            $emailTemplate = EmailTemplate::find($id);
            if (!$emailTemplate) {
                Alert::toast('Email Template not found!', 'error');
                return redirect()->route('email_templates');
            }

            $emailTemplate->delete();
            Alert::toast('Email Template has been deleted successfully!', 'success');
            return redirect()->route('email_templates');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit email template')) {
                return view('admin.errors.unauthorized');
            }
            $emailTemplate = EmailTemplate::find($id);
            if (!$emailTemplate) {
                Alert::toast('Email Template not found!', 'error');
                return redirect()->route('email_templates');
            }

            $emailTemplate->status = 1;
            $emailTemplate->save();
            Alert::toast('Email Template has been activated successfully!', 'success');
            return redirect()->route('email_templates');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit email template')) {
                return view('admin.errors.unauthorized');
            }
            $emailTemplate = EmailTemplate::find($id);
            if (!$emailTemplate) {
                Alert::toast('Email Template not found!', 'error');
                return redirect()->route('email_templates');
            }

            $emailTemplate->status = 0;
            $emailTemplate->save();
            Alert::toast('Email Template has been inactivated successfully!', 'success');
            return redirect()->route('email_templates');
        } catch (\Exception $e) {
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}
