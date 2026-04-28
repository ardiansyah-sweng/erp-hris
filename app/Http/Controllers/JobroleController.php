<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobroleService;

class JobroleController extends Controller
{
    /**
     * Method untuk menghapus data Job Role
     */
    public function destroy($id, JobroleService $jobroleService)
    {
        $jobroleService->destroyJobrole($id);
        return redirect('/job-roles')->with('success', 'Job role berhasil dihapus');
    }
}