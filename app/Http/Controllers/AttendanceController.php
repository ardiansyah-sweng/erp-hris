<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $attendances,
        ]);
    }
}