<?php

use App\Http\Controllers\JobroleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', [JobroleController::class, 'index']);
