<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::with('department')
            ->latest()
            ->get();

        return view('training.index', compact('trainings'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('training.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'location' => 'required|string|max:255',
            'training_date' => 'required|date',
            'status' => 'required',
            'description' => 'nullable|string',
        ]);

        Training::create($request->all());

        return redirect()
            ->route('training.index')
            ->with('success', 'Training berhasil ditambahkan.');
    }

    public function edit(Training $training)
    {
        $departments = Department::orderBy('name')->get();

        return view('training.edit', compact(
            'training',
            'departments'
        ));
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'training_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required',
            'description' => 'nullable|string',
        ]);

        $training->update([
            'title' => $request->title,
            'trainer' => $request->trainer,
            'department_id' => $request->department_id,
            'training_date' => $request->training_date,
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('training.index')
            ->with('success', 'Training berhasil diperbarui.');
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()
            ->route('training.index')
            ->with('success', 'Training berhasil dihapus.');
    }
    
    public function show(Training $training)
    {
        $training->load('department');

        return view('training.show', compact('training'));
    }
}