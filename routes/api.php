<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post(uri: '/register', action: [AuthController::class, 'register']);
Route::post(uri: '/login', action: [AuthController::class, 'login']);
Route::get(uri: '/projects', action: [ProjectController::class, 'index']);
Route::post(uri: '/projects', action: [ProjectController::class, 'store']);
Route::put(uri: '/projects', action: [ProjectController::class, 'update']);
Route::get(uri: '/user', action: function (Request $request) {
    return $request->user();
})->middleware(middleware: 'auth:sanctum');
