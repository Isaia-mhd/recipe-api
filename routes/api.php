<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function () {

    // REVIEWS
    Route::post("reviews/new/recipe/{recipe}", [ReviewController::class,"store"]);
    Route::delete("reviews/delete/{review}", [ReviewController::class,"destroy"]);


    // FAVORITES
    Route::get("favorites", [FavoriteController::class, "index"]);
    Route::post("favorites/new/recipe/{recipe}", [FavoriteController::class, "store"]);
    Route::delete("favorites/delete/{favorite}", [FavoriteController::class, "destroy"]);


    // RECIPES
    Route::get("recipes", [RecipeController::class,"index"]);
    Route::get("recipes/show/{recipe}", [RecipeController::class,"show"]);
    Route::post("recipes/new", [RecipeController::class,"store"]);
    Route::put("recipes/update/{recipe}", [RecipeController::class,"update"]);
    Route::delete("recipes/delete/{recipe}", [RecipeController::class,"destroy"]);


     // USER
     Route::get("/users", [UserController::class, "index"]);
     Route::get("/users/show/{user}", [UserController::class, "show"]);
     Route::put("/users/update/{user}", [UserController::class, "update"]);
     Route::put("/users/update-role/{user}", [UserController::class, "updateRole"]);
     Route::delete("/users/destroy/{user}", [UserController::class, "destroy"]);
});

Route::middleware("guest")->group(function () {
    // USER
    Route::post("/forgot-password", [AuthController::class, "forgotPassword"]);
    Route::post("/reset-password", [AuthController::class, "resetPassword"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [UserController::class, "store"]);
});
