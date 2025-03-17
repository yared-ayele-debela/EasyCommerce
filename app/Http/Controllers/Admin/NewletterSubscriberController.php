<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppSetting;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;

class NewletterSubscriberController extends Controller
{

    public function create()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('send_newsletters')) {
                return view('admin.errors.unauthorized');
            }
            $all_users = User::all()->where('status', 1);
            // dd($all_users);
            $appsettings = AppSetting::all()->toArray();

            return view('admin.newsletters.send_email_all_users', compact('all_users', 'appsettings'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function send(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('send_newsletters')) {
                return view('admin.errors.unauthorized');
            }
            if (!$request->method('post')) {                // Log or handle the exception as needed
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }
            $newsletter = NewsletterSubscriber::get(); // Fetch all users (you may have a different way to fetch users)
            $subject = $request->input('subject');
            $message = $request->input('message');
            foreach ($newsletter as $newsletter) {
                Mail::to($newsletter->email)->send(new \App\Mail\NewsLetterEmail($subject, $message));
            }
            Alert::toast('Email sent to all users!', 'success');
            return redirect()->route('newslettersubscribers');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }


    public function lists()
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('view_newsletters')) {
                Alert::toast('Access Denied', 'error');
                return redirect()->back();
            }
            $appsettings = AppSetting::all()->toArray();
            $cms_pages = CmsPage::get()->toArray();

            $allnewsletter = NewsletterSubscriber::all()->toArray();

            return view('admin.newsletters.allnewsletters', compact('allnewsletter', 'appsettings', 'cms_pages'));
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('delete_newsletter')) {
                return view('admin.errors.unauthorized');
            }

            $news = NewsletterSubscriber::find($id);
            $news->delete();
            Alert::toast('Newsletters has been deleted!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_newsletter')) {
                return view('admin.errors.unauthorized');
            }
            $news = NewsletterSubscriber::find($id);
            $news->status = 1;
            $news->update();
            Alert::toast('Newsletters has been actived!', 'success');

            return redirect()->back();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
    public function inactive($id)
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user || !$user->hasPermissionByRole('edit_newsletter')) {
                return view('admin.errors.unauthorized');
            }
            $news = NewsletterSubscriber::find($id);
            $news->status = 0;
            $news->update();
            Alert::toast('Newsletters has been actived!', 'error');
            return redirect()->back();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            if (!$request->method('post')) {
                Alert::toast('something is wrong!!', 'error');
                return redirect()->back();
            }

            $validator = Validator::make($request->all(), [
                'email' => 'email|string|unique:newsletter_subscribers,email',
            ]);
            if ($validator->fails()) {
                Alert::toast('Subscriber email already exists', 'error');
                return redirect()->back();
            } else {

                $newsletter = new NewsletterSubscriber();
                $newsletter->email = $request->input('email');
                $newsletter->status = 1;
                $newsletter->save();
                Alert::toast('Thanks for subscribing our webiste', 'success');
                return redirect()->back();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel's built-in validation exception
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            Alert::toast('something is wrong!!', 'error');
            return redirect()->back();
        }
    }
}