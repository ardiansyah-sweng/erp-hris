<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobroleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return response()->json([
            'message' => 'store() berhasil dipanggil',
            'data' => $validated
        ]);
    }
}