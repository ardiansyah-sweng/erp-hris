<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobrole;
use App\Services\JobroleService;
use Exception;

class JobroleController extends Controller
{
    protected $jobroleService;

    public function __construct(JobroleService $jobroleService)
    {
        $this->jobroleService = $jobroleService;
    }

    public function index()
    {
        $jobroles = Jobrole::all();

        return view('job_role.index', compact('jobroles'));
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

    public function destroy(Jobrole $jobrole)
    {
        try {
            $jobrole->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'payload' => [
                        'statusCode' => 200,
                        'message' => 'Job role deleted successfully!',
                        'data' => [
                            'id' => $jobrole->id,
                            'role' => $jobrole->role,
                        ]
                    ]
                ], 200);
            }

            return redirect()->route('jobrole.index')
                ->with('success', 'Job role berhasil dihapus.');

        } catch (Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'payload' => [
                        'statusCode' => 500,
                        'message' => 'Gagal menghapus data job role.',
                        'error' => $e->getMessage()
                    ]
                ], 500);
            }

            return redirect()->route('jobrole.index')
                ->with('error', 'Gagal menghapus data job role.');
        }
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