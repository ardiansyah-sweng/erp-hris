<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobroleController;

Route::post('/test-jobrole', [JobroleController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});
