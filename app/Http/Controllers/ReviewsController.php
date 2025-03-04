<?php

namespace App\Http\Controllers;

use App\Models\CategoryReview;
use App\Models\Tutor;
use App\Models\TutorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{
    public function sendReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'tutor_id' => 'required|exists:tutors,id',
            'emp_id' => 'nullable',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $existingReview = TutorReview::where('parent_id', Auth::user()->id)
            ->where('tutor_id', $request->tutor_id)
            ->first();

        if ($existingReview) {
            return response()->json(['status' => false, 'message' => 'You have already submitted a review for this tutor.']);
        }

        $reviews = new TutorReview();
        $reviews->tutor_id = $request->tutor_id;
        $reviews->parent_id = Auth::user()->id;
        $reviews->rating = $request->rating;
        $reviews->description = $request->description;
        $reviews->save();

        return response()->json(['status' => true, 'message' => 'Review added successfully!']);
    }
    public function sendCategoryReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable',
            'category_id' => 'required',
            'emp_id' => 'nullable',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $existingReview = CategoryReview::where('parent_id', Auth::user()->id)
            ->where('category_id', $request->category_id)
            ->first();

        if ($existingReview) {
            return response()->json(['status' => false, 'message' => 'You have already submitted a review for this category.']);
        }

        $reviews = new CategoryReview();
        $reviews->category_id = $request->category_id;
        $reviews->parent_id = Auth::user()->id;
        $reviews->rating = $request->rating;
        $reviews->description = $request->description;
        $reviews->save();

        return response()->json(['status' => true, 'message' => 'Review added successfully!']);
    }

    public function tutorReviews(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->pagination_limit;
        $reviews = TutorReview::orderBy('id','desc')->paginate($paginationLimit);

        return view('backend.reviews.tutor_reviews',compact('paginationLimit','reviews','currentRoute'));


    }
    public function tutorTrashReviews(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->pagination_limit;
        $reviews = TutorReview::onlyTrashed()->orderBy('id', 'desc')->paginate($paginationLimit);

        return view('backend.reviews.trash_tutor_reviews',compact('paginationLimit','reviews','currentRoute'));


    }
    public function tutorReviewDelete(Request $request, $id)
    {
        $review = TutorReview::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return redirect()->back()->with('message', 'Review sended to trash.');
    }
    public function tutorReviewRestore(Request $request, $id)
    {
        $review = TutorReview::withTrashed()->where('id', $id)->first();

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->restore();

        return redirect()->back()->with('message', 'Review sended to trash.');
    }

    public function tutorReviewSearch(Request $request)
    {
        $currentRoute = \Route::currentRouteName();

        $paginationLimit = $request->pagination_limit ?? 10;

        $tutor = Tutor::where('unique_id', $request->search)->first();

        if (!$tutor) {
            return redirect()->back()->with('error', 'Tutor not found.');
        }

        $reviews = TutorReview::where('tutor_id', $tutor->id)
                            ->orderBy('id', 'desc')
                            ->paginate($paginationLimit);

        return view('backend.reviews.tutor_reviews', compact('paginationLimit', 'reviews', 'currentRoute'));
    }
}
