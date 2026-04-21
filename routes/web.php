<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 


Route::post('/employees', [EmployeeController::class, 'store']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});