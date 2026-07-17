<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    public function getAllJobrole()
    {
        return Jobrole::all();
    }

    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role' => $data['name'],
            'department' => $data['department'] ?? null,
            'level' => $data['level'] ?? null,
            'status' => $data['status'] ?? 'Active',
        ]);
    }

    public function showJobrole($id)
    {
        return Jobrole::findOrFail($id);
    }

    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role' => $data['name'],
            'department' => $data['department'] ?? $jobrole->department,
            'level' => $data['level'] ?? $jobrole->level,
            'status' => $data['status'] ?? $jobrole->status,
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