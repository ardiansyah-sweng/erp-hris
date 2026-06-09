<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::with('employee')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $absensis,
        ]);
    }
}
