<?php

namespace App\Observers;

use App\Models\Jobrole; // Sesuaikan jika nama model lu Jobrole atau JobRole
use Illuminate\Support\Facades\DB;

class JobRoleObserver
{
    public function created(Jobrole $jobRole): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Job Role',
            'description' => 'Menambahkan role jabatan baru: ' . ($jobRole->role ?? $jobRole->name),
            'created_at'  => now()
        ]);
    }

    public function updated(Jobrole $jobRole): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Job Role',
            'description' => 'Mengubah data role jabatan ID: ' . $jobRole->id,
            'created_at'  => now()
        ]);
    }

    public function deleted(Jobrole $jobRole): void
    {
        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Job Role',
            'description' => 'Menghapus role jabatan ID: ' . $jobRole->id,
            'created_at'  => now()
        ]);
    }
}