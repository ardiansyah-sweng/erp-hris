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
     * Menampilkan semua data job role (halaman index).
     */
    public function index()
    {
        $jobroles = $this->jobroleService->getAllJobrole();
        return view('job_role.index', compact('jobroles'));
    }

    /**
     * Menyimpan data job role baru.
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

            return redirect()->route('jobrole.index')
                ->with('success', 'Job role berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data job role: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail satu job role.
     */
    public function show($id)
    {
        try {
            $jobrole = $this->jobroleService->showJobrole($id);
            return view('job_role.detail', compact('jobrole'));
        } catch (Exception $e) {
            return redirect()->route('jobrole.index')
                ->with('error', 'Data job role tidak ditemukan.');
        }
    }

    /**
     * Menampilkan form edit job role.
     */
    public function edit($id)
    {
        try {
            $jobrole = $this->jobroleService->showJobrole($id);
            return view('job_role.edit', compact('jobrole'));
        } catch (Exception $e) {
            return redirect()->route('jobrole.index')
                ->with('error', 'Data job role tidak ditemukan.');
        }
    }

    /**
     * Mengupdate data job role.
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

            return redirect()->route('jobrole.index')
                ->with('success', 'Job role berhasil diperbarui!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data job role: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data job role.
     */
    public function destroy($id)
    {
        try {
            $deletedData = $this->jobroleService->destroyJobrole($id);

            return redirect()->route('jobrole.index')
                ->with('success', 'Job role "' . $deletedData['role'] . '" berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('jobrole.index')
                ->with('error', 'Gagal menghapus data job role: ' . $e->getMessage());
        }
    }
}