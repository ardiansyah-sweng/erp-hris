<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    public function createJobrole(array $data)
    {
        $jobrole = Jobrole::create([
            'role' => $data['role']
        ]);

        return $jobrole;
    }

    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update([
            'role' => $data['role']
        ]);

        return $jobrole;
    }
}