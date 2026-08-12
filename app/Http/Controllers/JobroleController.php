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
        $departments = Department::all();
        $levels      = Level::all();
        return view('job_role.create_jobrole', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'department_id' => 'nullable|integer|exists:departments,id',
            'level_id'      => 'nullable|integer|exists:levels,id',
            'status'       => 'nullable|string|max:255',
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
        $jobrole     = $this->jobroleService->showJobrole($id);
        $departments = Department::all();
        $levels      = Level::all();
        return view('job_role.edit', compact('jobrole', 'departments', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'department_id' => 'nullable|integer|exists:departments,id',
            'level_id'      => 'nullable|integer|exists:levels,id',
            'status'       => 'nullable|string|max:255',
        ]);

        $this->jobroleService->updateJobrole($id, $validated);

        return redirect()->route('jobrole.index')
            ->with('success', 'Job role berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $result = $this->jobroleService->destroyJobrole($id);

        if ($request->expectsJson()) {
            return response()->json([
                'payload' => $result
            ], $result['statusCode'] ?? 200);
        }

        if (isset($result['statusCode']) && $result['statusCode'] !== 200) {
            return redirect()->route('jobrole.index')
                ->with('error', $result['message'] ?? 'Gagal menghapus job role.');
        }

        return redirect()->route('jobrole.index')
            ->with('success', $result['message'] ?? 'Job role berhasil dihapus.');
    }
}