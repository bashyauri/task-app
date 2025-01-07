<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get(uri: '/', action: function () {
//     return view(view: 'welcome');
// });
Route::get('/', function () {
    return redirect('/app/login');
});

Route::get('/app/{any}', function () {
    return view('welcome');
});

Route::get(uri: '/check_email/{token}', action: [AuthController::class, 'validateEmail']);
