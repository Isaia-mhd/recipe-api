<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with("reviews", "user")->get();

        return response()->json(["recipes" => $recipes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {

        $categoryIds = Category::whereIn('name', $request->category_names)->pluck('id')->toArray();
        $userId = Auth::user()->id;
        $recipe = Recipe::create([
            "user_id" => $userId,
            "title" => $request->title,
            "description" => $request->description,
            "ingredients" => $request->ingredients,
            "instructions" => $request->instructions
        ]);

        $recipe->categories()->attach($categoryIds);

        return response()->json([
            "message"=> "Recipe Posted successfully.",
            "recipe" => $recipe->load("categories")
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return response()->json([
            "recipe" => $recipe
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, Recipe $recipe)
    {
        $userOwnerId = $recipe->user_id;
        if(Gate::denies("update-recipe", $userOwnerId))
        {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }

        $recipe->update($request->all());

        return response()->json([
            "message" => "Recipe Updated Successfully.",
            "recipe" => $recipe
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {

        $userOwnerId = $recipe->user_id;

        if(Gate::denies("delete-recipe", $userOwnerId))
        {
            return response()->json([
                "message" => "Unauthorized."
            ], 401);
        }

        $recipe->delete();
        return response()->json([
            "message" => "Recipe Deleted Successfully."
        ], 200);
    }
}
