<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    /**
     * Method untuk update data Job Role
     */
    public function updateJobrole($id, array $data)
    {
        // 1. Cari data berdasarkan ID, kalau nggak ada langsung error 404
        $jobrole = Jobrole::findOrFail($id);

        // 2. Update datanya pake data baru dari input
        $jobrole->update($data);

        // 3. Balikin data yang udah berhasil diupdate
        return $jobrole;
    }
}