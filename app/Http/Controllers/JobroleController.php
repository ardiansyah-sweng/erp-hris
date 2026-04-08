<?php

namespace App\Http\Controllers;

use App\Models\JobRole;

class JobroleController extends Controller
{
    public function index()
    {
        $jobRoles = JobRole::all();

        return response()->json([
            'success' => true,
            'data' => $jobRoles,
        ]);
    }
}
