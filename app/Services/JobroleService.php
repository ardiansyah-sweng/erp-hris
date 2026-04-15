<?php

namespace App\Services;

use App\Models\JobRole;

class JobroleService
{
    public function getAllJobRole()
    {
        return JobRole::all();
    }
}