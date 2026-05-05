<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobroleController;

Route::post('/test-jobrole', [JobroleController::class, 'store']);
use App\Http\Controllers\EmployeeController; 


Route::post('/employees', [EmployeeController::class, 'store']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});

Route::get('/job-roles/{id}', [JobroleController::class, 'show']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);
Route::get('/dashboard', function () {
    return view('dashboard');
});

//Edit file dummy ( karna belum ada controller edit dan updatenya)
Route::get('/employee/test-edit', function () {
    // Membuat data dummy agar variabel di view tidak error
    $employee = (object) [
        'id' => 1,
        'name' => 'Budi Setiawan',
        'email' => 'budi@erp-hris.com',
        'job_role_id' => 1, // ID untuk Cashier 
        'address' => 'Jl. Merdeka No. 45, Semarang'
    ];

    return view('employee.edit', compact('employee'));
});
// Route dummy untuk menangkap klik tombol Update dari form edit
Route::put('/employee/test-edit', function () {
    return "Tombol Update berhasil diklik! (Ini hanya simulasi, data belum tersimpan karena Controller Update asli belum disambungkan).";
});