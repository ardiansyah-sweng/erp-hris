<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobrole;

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
    //
}