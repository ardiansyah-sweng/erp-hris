<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobrole;
use Exception;

class JobroleController extends Controller
{
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