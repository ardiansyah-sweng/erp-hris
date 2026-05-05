<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{


    /**
     * Method untuk mengambil semua data Job Role
     */
    public function getAllJobrole()
    {
        // Mengambil semua data dari tabel jobroles
        return Jobrole::all();
    }
    public function showJobrole($id)
    {
        return Jobrole::findOrFail($id);
    }

    /**
     * Method untuk update data Job Role
     */
    public function updateJobrole($id, array $data)
    {
        // Cari data berdsarkan ID
        $jobrole = Jobrole::findOrFail($id);

        // Melakukan update data kolom 'role'
        $jobrole->update([
            'role' => $data['role']
        ]);

        return $jobrole;
    }
}