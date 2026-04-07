<?php

namespace App\Http\Controllers;

use App\Models\JobRole;

class JobroleController extends Controller
{
    public function index()
    {
        $jobRoles = JobRole::all();

        return view('job_role.index', compact('jobRoles'));
    }
}
