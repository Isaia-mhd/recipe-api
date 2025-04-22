<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware("auth:sanctum")->group(function () {
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
