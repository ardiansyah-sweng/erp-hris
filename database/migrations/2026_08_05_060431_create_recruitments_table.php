<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use App\Models\Jobrole;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        $recruitments = Recruitment::with('jobRole')
            ->latest()
            ->get();

        return view('recruitment.index', compact('recruitments'));
    }

    public function create()
    {
        $jobroles = Jobrole::orderBy('role')->get();

        return view('recruitment.create', compact('jobroles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'role_id' => 'required|exists:job_roles,id',
            'apply_date' => 'required|date',
            'status' => 'required',
            'notes' => 'nullable|string',
        ]);

        Recruitment::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role_id' => $request->role_id,
            'apply_date' => $request->apply_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Recruitment berhasil ditambahkan.');
    }

    public function show(Recruitment $recruitment)
    {
        $recruitment->load('jobRole');

        return view('recruitment.show', compact('recruitment'));
    }

    public function edit(Recruitment $recruitment)
    {
        $jobroles = Jobrole::orderBy('role')->get();

        return view('recruitment.edit', compact(
            'recruitment',
            'jobroles'
        ));
    }

    public function update(Request $request, Recruitment $recruitment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'role_id' => 'required|exists:job_roles,id',
            'apply_date' => 'required|date',
            'status' => 'required',
            'notes' => 'nullable|string',
        ]);

        $recruitment->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role_id' => $request->role_id,
            'apply_date' => $request->apply_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Recruitment berhasil diperbarui.');
    }

    public function destroy(Recruitment $recruitment)
    {
        $recruitment->delete();

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Recruitment berhasil dihapus.');
    }
}