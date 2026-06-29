<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
   
    public function createJobrole(array $data)
    {
        return Jobrole::create([
            'role' => $data['role']
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

        $jobrole->update([
            'role' => $data['role']
        ]);

        return $jobrole;
    }

    public function destroyJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $deletedData = [
            'id' => $jobrole->id,
            'role' => $jobrole->role,
        ];
        $jobrole->delete();

        return $deletedData;
    }
}