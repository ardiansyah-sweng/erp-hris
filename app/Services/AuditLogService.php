<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class AuditLogService
{
    public function getAllLogs()
    {
        // Mengambil seluruh log aktivitas terbaru
        return DB::table('activity_logs')->orderBy('created_at', 'desc')->get();
    }

    public function storeLog($userEmail, $action, $module, $description)
    {
        // Fungsi pembantu (helper) untuk merekam aksi ke database
        DB::table('activity_logs')->insert([
            'user_email' => $userEmail,
            'action' => $action,
            'module' => $module,
            'description' => $description
        ]);
    }
}