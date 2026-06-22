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

    /**
     * Create a new job role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $jobrole = $this->jobroleService->createJobrole([
                'role' => $validated['name'],
            ]);

            return response()->json([
                'payload' => [
                    'statusCode' => 201,
                    'message' => 'Data berhasil disimpan',
                    'data' => $jobrole,
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menyimpan data job role.',
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Get all job roles.
     */
    public function index()
    {
        try {
            $jobroles = $this->jobroleService->getAllJobrole();

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Data job role berhasil diambil',
                    'data' => $jobroles,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal mengambil data job role.',
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Show a single job role by ID.
     */
    public function show($id)
    {
        try {
            $jobrole = $this->jobroleService->showJobrole($id);

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Detail job role berhasil diambil',
                    'data' => $jobrole,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 404,
                    'message' => 'Data job role tidak ditemukan.',
                    'error' => $e->getMessage(),
                ]
            ], 404);
        }
    }

    /**
     * Update an existing job role.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $jobrole = $this->jobroleService->updateJobrole($id, [
                'role' => $validated['name'],
            ]);

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Data job role berhasil diperbarui',
                    'data' => $jobrole,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal memperbarui data job role.',
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }

    /**
     * Delete a job role.
     */
    public function destroy($id)
    {
        try {
            $deletedData = $this->jobroleService->destroyJobrole($id);

            return response()->json([
                'payload' => [
                    'statusCode' => 200,
                    'message' => 'Job role deleted successfully!',
                    'data' => $deletedData,
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'payload' => [
                    'statusCode' => 500,
                    'message' => 'Gagal menghapus data job role.',
                    'error' => $e->getMessage(),
                ]
            ], 500);
        }
    }
}