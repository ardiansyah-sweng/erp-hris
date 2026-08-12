<?php

namespace App\Services;

use App\Models\Jobrole;
use App\Models\Employee;
use Exception;

class JobroleService
{
    public function getAllJobrole()
    {
        return Jobrole::with(['department', 'level'])->get();
    }

    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role'          => $data['name'] ?? $data['role'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'level_id'      => $data['level_id'] ?? null,
            'status'        => $data['status'] ?? 'Active',
        ]);
    }

    public function showJobrole($id)
    {
        return Jobrole::with(['department', 'level'])->findOrFail($id);
    }

    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role'          => $data['name'] ?? $data['role'] ?? $jobrole->role,
            'department_id' => $data['department_id'] ?? $jobrole->department_id,
            'level_id'      => $data['level_id'] ?? $jobrole->level_id,
            'status'        => $data['status'] ?? $jobrole->status,
        ]);

        return $jobrole;
    }


    /**
     * Menghapus data Jobrole berdasarkan ID dengan validasi lengkap.
     *
     * Fitur yang diimplementasikan:
     * 1. Validasi parameter ID sebelum diproses.
     * 2. Pencarian data Jobrole berdasarkan ID menggunakan Eloquent.
     * 3. Validasi keberadaan data Jobrole (berhenti jika tidak ditemukan).
     * 4. Validasi relasi — memastikan tidak ada Employee yang menggunakan Jobrole ini.
     * 5. Proses penghapusan dengan try-catch untuk penanganan error.
     * 6. Response konsisten (statusCode, message, data/error).
     *
     * @param  mixed  $id
     * @return array
     */
    public function destroyJobrole($id)
    {
        // 1. Validasi parameter ID yang diterima
        if (empty($id) || !is_numeric($id) || (int) $id <= 0) {
            return [
                'statusCode' => 400,
                'message'    => 'Parameter ID tidak valid.',
                'data'       => null,
            ];
        }

        try {
            // 2. Pencarian data Jobrole berdasarkan ID menggunakan Eloquent
            $jobrole = Jobrole::find($id);

            // 3. Validasi keberadaan data Jobrole
            if (!$jobrole) {
                return [
                    'statusCode' => 404,
                    'message'    => 'Data jobrole tidak ditemukan.',
                    'data'       => null,
                ];
            }

            // 4. Validasi relasi — pastikan tidak ada Employee yang menggunakan Jobrole ini
            $employeeCount = Employee::where('role_id', $jobrole->id)->count();

            if ($employeeCount > 0) {
                return [
                    'statusCode' => 409,
                    'message'    => 'Jobrole tidak dapat dihapus karena masih digunakan oleh '
                                    . $employeeCount . ' data karyawan.',
                    'data'       => null,
                ];
            }

            // 5. Proses penghapusan data Jobrole
            $jobrole->delete();

            // 6. Response sukses dengan format konsisten
            return [
                'statusCode' => 200,
                'message'    => 'Jobrole berhasil dihapus.',
                'data'       => [
                    'id'   => $jobrole->id,
                    'role' => $jobrole->role,
                ],
            ];

        } catch (Exception $e) {
            // 5 & 6. Penanganan error dan response gagal
            return [
                'statusCode' => 500,
                'message'    => 'Gagal menghapus data jobrole.',
                'error'      => $e->getMessage(),
            ];
        }
    }
}

