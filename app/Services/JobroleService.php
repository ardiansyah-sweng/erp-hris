<?php

namespace App\Services;

use App\Models\Jobrole;
use Exception;

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
        try {
            $jobrole = Jobrole::findOrFail($id);
            $jobrole->delete();

            return [
                'statusCode' => 200,
                'message' => 'Job role deleted successfully!',
                'data' => [
                    'id' => $jobrole->id,
                    'role' => $jobrole->role
                ]
            ];
        } catch (Exception $e) {
            return [
                'statusCode' => 500,
                'message' => 'Gagal menghapus data job role.',
                'error' => $e->getMessage()
            ];
        }
    }
}