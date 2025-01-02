<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post(uri: '/register', action: [AuthController::class, 'register']);
Route::post(uri: '/login', action: [AuthController::class, 'login']);

Route::controller(controller: ProjectController::class)->group(function () {
    Route::get(uri: '/projects', action: 'index');
    Route::post(uri: '/projects', action: 'store');
    Route::put(uri: '/projects', action: 'update');
    Route::post(uri: '/projects/pinned', action: 'pinnedProject');
});

Route::get(uri: '/user', action: function (Request $request) {
    return $request->user();
})->middleware(middleware: 'auth:sanctum');