<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;

Route::get('/cashiers', [EmployeeController::class, 'getCashiers']);

Route::get('/attendances', [AttendanceController::class, 'index']);
Route::get('/leave-requests/{employeeId}/balance', [LeaveRequestController::class, 'balance']);

Route::get('/attendances', [AttendanceController::class, 'apiIndex']);

