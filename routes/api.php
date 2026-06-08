<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/cashiers', [EmployeeController::class, 'getCashiers']);
Route::get('/employees/role/{id}', [EmployeeController::class, 'getEmployeesByJobRole']);