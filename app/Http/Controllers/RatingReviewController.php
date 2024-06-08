<?php

namespace App\Http\Controllers;

use App\Models\RatingReview;
use App\Models\Setting;
use Illuminate\Http\Request;
use Auth;

class RatingReviewController extends Controller
{
    public function index()
    {
        $review_data = RatingReview::with('product')->paginate(10);
        return view('admin.rating.index', compact('review_data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'product_id' => 'required',
            'rating' => 'required',
            'review_title' => 'required',
            'review' => 'required',
        ]);
        $data = new RatingReview();
        $data->product_id = $request->product_id;
        $data->customer_id = Auth::user()->id;
        $data->name = $request->name ?? 'N/A';
        $data->rating = $request->rating ?? 'N/A';
        $data->review_title = $request->review_title ?? 'N/A';
        $data->review = $request->review ?? 'N/A';

        $user = Auth::user(); // Assuming you are using Laravel's authentication
        if ($user) {
            $userReviewsCount = RatingReview::where('name', $user->name)->orWhere('customer_id', Auth::user()->id)->count();

            if ($userReviewsCount == 0) {

                $user->points += 500;
            }else{
                $user->points += 100;
            }
            $data->save();
            $user->save();
            $alert = ['success', 'Comment insert Successfully!'];
            return back()->withAlert($alert);
        } else {
            return back();
        }
    }
    public function delete($id)
    {
        $data = RatingReview::findOrfail($id);
        $data->delete();
        $alert = ['success', 'Review Delete Successfully!'];
        return back()->withAlert($alert);
    }
}
