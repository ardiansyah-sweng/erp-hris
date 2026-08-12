<?php

namespace App\Observers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeObserver
{
    public function created(Employee $employee): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Employee',
            'description' => 'Menambahkan karyawan baru: ' . $employee->name . ' (ID: ' . $employee->id . ')',
            'created_at'  => now()
        ]);
    }

    public function updated(Employee $employee): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Employee',
            'description' => 'Memperbarui data profil karyawan: ' . $employee->name . ' (ID: ' . $employee->id . ')',
            'created_at'  => now()
        ]);
    }

    public function deleted(Employee $employee): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Employee',
            'description' => 'Menghapus karyawan: ' . $employee->name . ' (ID: ' . $employee->id . ')',
            'created_at'  => now()
        ]);
    }
}