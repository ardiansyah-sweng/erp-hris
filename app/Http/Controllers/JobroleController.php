<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobrole;
use App\Models\Department;
use App\Models\Level;
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
        $jobroles = $this->jobroleService->getAllJobrole();
        return view('job_role.index', compact('jobroles'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('job_role.create', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'level_id'      => 'nullable|exists:levels,id',
            'status'        => 'nullable|string|max:255',
        ]);

        $jobrole = $this->jobroleService->createJobrole([
            'role'          => $validated['name'],
            'department_id' => $validated['department_id'] ?? null,
            'level_id'      => $validated['level_id'] ?? null,
            'status'        => $validated['status'] ?? 'Active',
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $jobrole
        ], 201);
    }

    public function show($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        return view('job_role.detail', compact('jobrole'));
    }

    public function edit($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('job_role.edit', compact('jobrole', 'departments', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'level_id'      => 'nullable|exists:levels,id',
            'status'        => 'nullable|string|max:255',
        ]);

        $this->jobroleService->updateJobrole($id, [
            'role'          => $validated['name'],
            'department_id' => $validated['department_id'] ?? null,
            'level_id'      => $validated['level_id'] ?? null,
            'status'        => $validated['status'] ?? 'Active',
        ]);

        return redirect()->route('jobrole.index')
            ->with('success', 'Job role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $jobrole = Jobrole::findOrFail($id);
            $jobrole->delete();

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

        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menghapus data job role.',
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }
}