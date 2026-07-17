<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    public function getAllJobrole()
    {
        return Jobrole::with(['department', 'level', 'status'])->get();
    }

    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role'          => $data['name'],
            'department_id' => $data['department_id'] ?? null,
            'level_id'      => $data['level_id'] ?? null,
            'status_id'     => $data['status_id'] ?? null,
        ]);
    }

    public function showJobrole($id)
    {
        return Jobrole::with(['department', 'level', 'status'])->findOrFail($id);
    }

    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role'          => $data['name'],
            'department_id' => $data['department_id'] ?? $jobrole->department_id,
            'level_id'      => $data['level_id'] ?? $jobrole->level_id,
            'status_id'     => $data['status_id'] ?? $jobrole->status_id,
        ]);

        return $jobrole;
    }

    public function deleteJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $jobrole->delete();
        return $jobrole;
    }
}
