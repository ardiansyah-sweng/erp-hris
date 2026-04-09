<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 

Route::post('/employees', [EmployeeController::class, 'store']);