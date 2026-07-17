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
        $jobroles = $this->jobroleService->getAllJobrole();
        return view('job_role.index', compact('jobroles'));
    }

    public function create()
    {
        return view('job_role.create_jobrole');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $jobrole = $this->jobroleService->createJobrole($validated);

        return redirect()->route('jobrole.index')
            ->with('success', 'Job role berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        return view('job_role.detail', compact('jobrole'));
    }

    public function edit($id)
    {
        $jobrole = $this->jobroleService->showJobrole($id);
        return view('job_role.edit', compact('jobrole'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $this->jobroleService->updateJobrole($id, $validated);

        return redirect()->route('jobrole.index')
            ->with('success', 'Job role berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->jobroleService->deleteJobrole($id);

            if ($request->expectsJson()) {
                return response()->json([
                    'payload' => [
                        'statusCode' => 200,
                        'message' => 'Job role deleted successfully!',
                    ]
                ], 200);
            }

            return redirect()->route('jobrole.index')
                ->with('success', 'Job role berhasil dihapus.');

        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'payload' => [
                        'statusCode' => 500,
                        'message' => 'Gagal menghapus data job role.',
                        'error' => $e->getMessage()
                    ]
                ], 500);
            }

            return redirect()->route('jobrole.index')
                ->with('error', 'Gagal menghapus job role.');
        }
    }
}