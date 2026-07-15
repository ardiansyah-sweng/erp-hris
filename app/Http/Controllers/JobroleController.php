<?php

namespace App\Http\Controllers;

use App\Services\JobroleService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jobrole = $this->jobroleService->createJobrole([
            'role' => $validated['name'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $jobrole
            ], 201);
        }

        return redirect()
            ->route('jobrole.index')
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
        ]);

        $jobrole = $this->jobroleService->updateJobrole($id, [
            'role' => $validated['name'],
        ]);

        return redirect()
            ->route('jobrole.index')
            ->with('success', 'Job role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $this->jobroleService->deleteJobrole($id);

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Job role deleted successfully!',
                    'data' => ['id' => $id]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menghapus data job role.',
                ]
            ], 500);
        }
    }
}