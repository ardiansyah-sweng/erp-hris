<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
   
    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role'          => $data['role'],
            'department_id' => $data['department_id'] ?? null,
            'level_id'      => $data['level_id'] ?? null,
            'status'        => $data['status'] ?? 'Active',
        ]);
    }

    public function getAllJobrole()
    {
        return Jobrole::with(['department', 'level'])->get();
    }

    public function showJobrole($id)
    {
        return Jobrole::with(['department', 'level'])->findOrFail($id);
    }

    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);
        $jobrole->update($data);
        return $jobrole;
    }
}