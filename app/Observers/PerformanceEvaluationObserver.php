<?php

namespace App\Observers;

use App\Models\PerformanceEvaluation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PerformanceEvaluationObserver
{
    /** 🔍 Helper Method: Mengambil nama karyawan berdasarkan employee_id */
    private function getEmployeeName(int $employeeId): string
    {
        $name = DB::table('employees')->where('id', $employeeId)->value('name');
        return $name ?? 'Karyawan ID: ' . $employeeId;
    }

    public function created(PerformanceEvaluation $eval): void
    {
        $employeeName = $this->getEmployeeName($eval->employee_id);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'hrd@erphris.com',
            'action'      => 'CREATE',
            'module'      => 'Performance Evaluation',
            'description' => 'Menginput nilai evaluasi kinerja baru untuk ' . $employeeName . ' (Skor: ' . ($eval->score ?? '-') . ')',
            'created_at'  => now()
        ]);
    }

    public function updated(PerformanceEvaluation $eval): void
    {
        $employeeName = $this->getEmployeeName($eval->employee_id);
        
        $changes = $eval->getChanges();
        $detailPerubahan = [];

        // 1. Pindah Orang (Diringkas jadi "Pindah dari X ke Y")
        if (array_key_exists('employee_id', $changes)) {
            $oldEmployeeId = $eval->getOriginal('employee_id');
            $oldName = $this->getEmployeeName($oldEmployeeId);
            $detailPerubahan[] = "Pindah dari [" . Str::limit($oldName, 10, '..') . "] ke [" . Str::limit($employeeName, 10, '..') . "]";
        }

        // 2. Skor (Diringkas jadi "Skor X->Y")
        if (array_key_exists('score', $changes)) {
            $oldScore = $eval->getOriginal('score') ?? '-';
            $newScore = $changes['score'];
            $detailPerubahan[] = "Skor " . $oldScore . "➔" . $newScore;
        }

        // 3. Tanggal (Diringkas jadi "Tgl X->Y")
        if (array_key_exists('evaluation_date', $changes)) {
            $oldDate = $eval->getOriginal('evaluation_date') ?? '-';
            $newDate = $changes['evaluation_date'];
            $detailPerubahan[] = "Tgl " . $oldDate . "➔" . $newDate;
        }

        // 4. Feedback (DIPOTONG LEBIH PENDEK: Max 15 Karakter)
        if (array_key_exists('feedback', $changes)) {
            $newFeedback = $changes['feedback'] ?? '';
            $singkatanFeedback = Str::limit($newFeedback, 15, '...');
            $detailPerubahan[] = "Fb: \"" . $singkatanFeedback . "\"";
        }

        // 5. Kriteria
        if (array_key_exists('criteria_scores', $changes)) {
            $detailPerubahan[] = "Kriteria diubah";
        }

        // Susun kalimat akhir super pendek (Hapus kata "Mengubah data penilaian kinerja milik...")
        if (!empty($detailPerubahan)) {
            $description = "Eval #" . $eval->id . " [" . Str::limit($employeeName, 15, '..') . "]: " . implode(', ', $detailPerubahan);
        } else {
            $description = "Update Eval #" . $eval->id . " [" . Str::limit($employeeName, 15, '..') . "]";
        }

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'hrd@erphris.com',
            'action'      => 'UPDATE',
            'module'      => 'Performance Evaluation',
            'description' => $description,
            'created_at'  => now()
        ]);
    }

    public function deleted(PerformanceEvaluation $eval): void
    {
        $employeeName = $this->getEmployeeName($eval->employee_id);

        DB::table('activity_logs')->insert([
            'user_email'  => auth()->user()->email ?? 'admin@erphris.com',
            'action'      => 'DELETE',
            'module'      => 'Performance Evaluation',
            'description' => 'Menghapus data penilaian kinerja milik ' . $employeeName,
            'created_at'  => now()
        ]);
    }
}