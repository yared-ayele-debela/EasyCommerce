<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RatingController extends Controller
{
    //
    public function addRating(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                //            echo "<pre>"; print_r($data);die;
                if (!Auth::check()) {
                    Alert::toast('Login to rate this product', 'error');
                    return redirect()->back();
                }
                if (!isset($data['rating'])) {
                    Alert::toast('Add at least one star rating for this product', 'error');
                    return  redirect()->back();
                }

                $ratingCount = Rating::where(['user_id' => Auth::user()->id, 'product_id' => $data['product_id']])->count();
                if ($ratingCount > 0) {
                    Alert::toast('Your rating already exists for this product', 'error');
                    return redirect()->back();
                } else {
                    $rating = new Rating();
                    $rating->user_id = Auth::user()->id;
                    $rating->product_id = $data['product_id'];
                    $rating->review = $data['review'];
                    $rating->rating = $data['rating'];
                    $rating->status = 0;
                    $rating->save();

                    Alert::toast('Thanks for rating this product!', 'success');
                    return  redirect()->back();
                }
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
