<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

Route::get('/cashiers', [EmployeeController::class, 'getCashiers']);
Route::get('/attendances', [AttendanceController::class, 'apiIndex']);