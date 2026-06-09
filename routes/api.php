<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AbsensiController;

Route::get('/cashiers', [EmployeeController::class, 'getCashiers']);
Route::get('/absensis', [AbsensiController::class, 'index']);