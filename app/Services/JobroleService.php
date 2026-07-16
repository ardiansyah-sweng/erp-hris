<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
   
    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role'       => $data['role'],
            'department' => $data['department'] ?? null,
            'level'      => $data['level'] ?? null,
            'status'     => $data['status'] ?? 'Active',
        ]);
    }

   
    public function getAllJobrole()
    {
        return Jobrole::all();
    }

    
    public function showJobrole($id)
    {
        return Jobrole::findOrFail($id);
    }

//    trigger
    public function updateJobrole($id, array $data)
    {
        $jobrole = Jobrole::findOrFail($id);

        $jobrole->update($data);

        return $jobrole;
    }
}