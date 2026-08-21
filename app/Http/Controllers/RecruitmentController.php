<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use App\Models\Jobrole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $search = $request->search;

    $recruitments = Recruitment::with('jobrole')
        ->when($search, function ($query) use ($search) {

            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('jobrole', function ($q) use ($search) {
                    $q->where('role', 'like', "%{$search}%");
                });

        })
        ->latest()
        ->get();

    return view('recruitment.index', compact(
        'recruitments',
        'search'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobroles = Jobrole::orderBy('role')->get();

        return view('recruitment.create', compact('jobroles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'role_id'      => 'required|exists:job_roles,id',
            'apply_date'   => 'required|date',
            'status'       => 'required',
            'notes'        => 'nullable|string',
            'cv'           => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $cv = null;

        if ($request->hasFile('cv')) {
            $cv = $request->file('cv')->store('cv', 'public');
        }

        Recruitment::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'role_id'      => $request->role_id,
            'apply_date'   => $request->apply_date,
            'status'       => $request->status,
            'notes'        => $request->notes,
            'cv'           => $cv,
        ]);

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Data recruitment berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recruitment $recruitment)
    {
    $recruitment->load('jobrole');

    return view('recruitment.show', compact('recruitment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recruitment $recruitment)
    {
        $jobroles = Jobrole::orderBy('role')->get();

        return view('recruitment.edit', compact(
            'recruitment',
            'jobroles'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recruitment $recruitment)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'role_id'      => 'required|exists:job_roles,id',
            'apply_date'   => 'required|date',
            'status'       => 'required',
            'notes'        => 'nullable|string',
            'cv'           => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $cv = $recruitment->cv;

        if ($request->hasFile('cv')) {

            if ($recruitment->cv &&
                Storage::disk('public')->exists($recruitment->cv)) {

                Storage::disk('public')->delete($recruitment->cv);
            }

            $cv = $request->file('cv')->store('cv', 'public');
        }

        $recruitment->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'role_id'      => $request->role_id,
            'apply_date'   => $request->apply_date,
            'status'       => $request->status,
            'notes'        => $request->notes,
            'cv'           => $cv,
        ]);

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Data recruitment berhasil diperbarui.');
    }

    /**
     * Update recruitment status only (from index dropdown).
     */
    public function updateStatus(Request $request, Recruitment $recruitment)
    {
        $request->validate([
            'status' => 'required|in:Screening,Interview,Accepted,Rejected',
        ]);

        $recruitment->update(['status' => $request->status]);

        return redirect()
            ->route('recruitment.index')
            ->with('success', "Status {$recruitment->name} diubah menjadi {$request->status}.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recruitment $recruitment)
    {
        if ($recruitment->cv &&
            Storage::disk('public')->exists($recruitment->cv)) {

            Storage::disk('public')->delete($recruitment->cv);
        }

        $recruitment->delete();

        return redirect()
            ->route('recruitment.index')
            ->with('success', 'Data recruitment berhasil dihapus.');
    }
}