<?php

namespace App\Http\Controllers;

use App\Services\JobroleService;
use App\Models\Jobrole;

class JobroleController extends Controller
{
    protected $jobroleService;

    public function __construct(JobroleService $jobroleService)
    {
        $this->jobroleService = $jobroleService;
    }

    public function index()
    {
        $roles = Jobrole::all(); // Ambil semua data dari job_roles
        return view('job_role.index', compact('roles')); // Kirim data ke view
    }

    public function destroy($id)
    {
        // Mengambil method destroyJobrole dari JobroleService
        $this->jobroleService->destroyJobrole($id);
        return redirect()->back();
    }
}