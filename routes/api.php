<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Project routes
Route::controller(ProjectController::class)->group(function () {
    Route::get('/projects', 'index');
    Route::post('/projects', 'store');
    Route::put('/projects', 'update');
    Route::post('/projects/pinned', 'pinnedProject');
    Route::get('/projects/{slug}', 'getProjects');
    Route::get('count/projects', 'countProject');
});

// Member routes
Route::controller(MemberController::class)->group(function () {
    Route::get('/members', 'index');
    Route::post('/members', 'store');
    Route::put('/members', 'update');
});

// Member routes
Route::controller(TaskController::class)->group(function () {

    Route::post('/tasks', 'createTask');
});

// User route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
