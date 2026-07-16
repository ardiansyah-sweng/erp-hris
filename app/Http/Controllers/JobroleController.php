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

    public function edit($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        return view('job_role.edit', compact('jobrole'));
    }

    public function index()
    {
        $jobroles = $this->jobroleService->getAllJobrole();
        return view('job_role.index', compact('jobroles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role'       => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'level'      => 'nullable|string|max:255',
            'status'     => 'nullable|string|max:255',
        ]);

        $this->jobroleService->updateJobrole($id, $validated);

        return redirect()->route('jobrole.index')
            ->with('success', 'Job role berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'level'      => 'nullable|string|max:255',
            'status'     => 'nullable|string|max:255',
        ]);

        $jobrole = $this->jobroleService->createJobrole([
            'role'       => $validated['name'],
            'department' => $validated['department'] ?? null,
            'level'      => $validated['level'] ?? null,
            'status'     => $validated['status'] ?? 'Active',
        ]);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $jobrole
        ], 201);
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
    
    public function show($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        return view('job_role.detail', compact('jobrole'));
    }
}