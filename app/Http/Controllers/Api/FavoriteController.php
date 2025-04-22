<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $favorites = Favorite::with("recipe")->where("user_id", $userId)->get();

        return response()->json([
            "favorites" => $favorites
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Recipe $recipe)
    {
        $userId = Auth::user()->id;

        Favorite::create([
            "user_id" => $userId,
            "recipe_id" => $recipe->id
        ]);

        return response()->json([
            "message" => "Recipe added to favorite"
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {

        $userOwnerId = $favorite->user_id;

        if(Gate::denies("delete-favorite", $userOwnerId))
        {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }
        
        $favorite->delete();

        return response()->json([
            "message" => "Favorite removed"
        ], 200);
    }
}
