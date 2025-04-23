<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Recipe;
use App\Models\Reviews;
use App\Notifications\NewReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, $recipe)
    {
        $userId = Auth::user()->id;
        $recipe = Recipe::find($recipe);
        if(!$recipe)
        {
            return response()->json([
                "message" => "Recipe does not exist."
            ], 404);
        }

        $review = Reviews::create([
            "user_id" => $userId,
            "recipe_id" => $recipe->id,
            "comment" => $request->comment,
            "rating" => $request->rating
        ]);

        $review->recipe->user->notify(new NewReview($review));


        return response()->json([
            "message" => "Review placed.",
            "review" => $review
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($review)
    {
        $review = Reviews::find($review);

        if(!$review)
        {
            return response()->json([
                "message" => "Review does not exist anymore"
            ], 404);
        }

        $reviewOwnerId = $review->id;
        if(Gate::denies("delete-review", $reviewOwnerId))
        {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }

        $review->delete();

        return response()->json([
            "message" => "Review Removed"
        ], 200);
    }
}
