<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobrole;

class JobroleController extends Controller
{
    public function index(Request $request)
{
    $dummyData = collect([
        (object)['id' => 1, 'name' => 'Software Engineer',  'department' => 'IT',              'level' => 'Staff',   'status' => 'Active'],
        (object)['id' => 2, 'name' => 'Data Analyst',       'department' => 'Data',            'level' => 'Senior',  'status' => 'Active'],
        (object)['id' => 3, 'name' => 'HR Manager',         'department' => 'Human Resources', 'level' => 'Manager', 'status' => 'On Leave'],
        (object)['id' => 4, 'name' => 'Quality Assurance',  'department' => 'IT',              'level' => 'Staff',   'status' => 'Active'],
        (object)['id' => 5, 'name' => 'Product Manager',    'department' => 'Product',         'level' => 'Manager', 'status' => 'Active'],
    ]);

    // FILTER DEPARTEMEN
    if ($request->department) {
        $dummyData = $dummyData->where('department', $request->department);
    }

    // SEARCH ROLE
    if ($request->search) {
        $dummyData = $dummyData->filter(function ($item) use ($request) {
            return stripos($item->name, $request->search) !== false;
        });
    }

    // AMBIL SEMUA DEPARTEMEN
    $departments = collect([
        'IT',
        'Data',
        'Human Resources',
        'Product'
    ]);

    return view('job_role.index', compact('dummyData', 'departments'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jobrole = Jobrole::create([
            'role' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $jobrole
        ], 201);
    }
    
    public function show($id)
    {
        $dummyData = [
            1 => (object)['id' => 1, 'name' => 'Software Engineer',  'department' => 'IT',               'level' => 'Staff',   'status' => 'Active',   'created_at' => '2025-01-01 08:00:00', 'updated_at' => '2025-04-10 10:00:00'],
            2 => (object)['id' => 2, 'name' => 'Data Analyst',       'department' => 'Data',             'level' => 'Senior',  'status' => 'Active',   'created_at' => '2025-01-01 08:00:00', 'updated_at' => '2025-04-10 10:00:00'],
            3 => (object)['id' => 3, 'name' => 'HR Manager',         'department' => 'Human Resources',  'level' => 'Manager', 'status' => 'On Leave', 'created_at' => '2025-01-01 08:00:00', 'updated_at' => '2025-04-10 10:00:00'],
            4 => (object)['id' => 4, 'name' => 'Quality Assurance',  'department' => 'IT',               'level' => 'Staff',   'status' => 'Active',   'created_at' => '2025-01-01 08:00:00', 'updated_at' => '2025-04-10 10:00:00'],
            5 => (object)['id' => 5, 'name' => 'Product Manager',    'department' => 'Product',          'level' => 'Manager', 'status' => 'Active',   'created_at' => '2025-01-01 08:00:00', 'updated_at' => '2025-04-10 10:00:00'],
        ];
 
        $jobrole = $dummyData[$id] ?? abort(404);
        return view('job_role.detail', compact('jobrole'));
    }
}