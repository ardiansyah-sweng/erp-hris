<?php

namespace App\Services;

use App\Models\Jobrole;

class JobroleService
{
    public function destroyJobrole($id)
    {
        $jobrole = Jobrole::findOrFail($id);
        $jobrole->delete();
    }
}