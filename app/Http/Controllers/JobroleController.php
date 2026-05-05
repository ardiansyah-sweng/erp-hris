<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
class JobRoleController extends Controller
=======
use App\Models\Jobrole;

class JobroleController extends Controller
>>>>>>> 6054f43c175f5e91ec8c3d0c7a413cc581895e3e
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
    //
}