<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PerformanceEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = PerformanceEvaluation::with(['employee', 'evaluator'])
            ->latest('evaluation_date')
            ->get();

        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();

        return view('evaluations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'evaluation_date' => 'required|date',
            'feedback' => 'nullable',
            'criteria_scores' => ['required', 'array:' . implode(',', array_keys(PerformanceEvaluation::CRITERIA))],
            'criteria_scores.*' => 'required|integer|between:1,5',
        ]);

        $validated['score'] = (int) round(array_sum($validated['criteria_scores']) / count($validated['criteria_scores']));
        $validated['evaluator_id'] = Auth::id();

        PerformanceEvaluation::create($validated);

        return redirect()->route('evaluations.index')->with('success', 'Evaluasi kinerja berhasil ditambahkan.');
    }

    public function edit(PerformanceEvaluation $evaluation)
    {
        $employees = Employee::orderBy('name')->get();

        return view('evaluations.edit', compact('evaluation', 'employees'));
    }

    public function update(Request $request, PerformanceEvaluation $evaluation)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'evaluation_date' => 'required|date',
            'feedback' => 'nullable',
            'criteria_scores' => ['required', 'array:' . implode(',', array_keys(PerformanceEvaluation::CRITERIA))],
            'criteria_scores.*' => 'required|integer|between:1,5',
        ]);

        $validated['score'] = (int) round(array_sum($validated['criteria_scores']) / count($validated['criteria_scores']));

        $evaluation->update($validated);

        return redirect()->route('evaluations.index')->with('success', 'Evaluasi kinerja berhasil diperbarui.');
    }

    public function destroy(PerformanceEvaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('evaluations.index')->with('success', 'Evaluasi kinerja berhasil dihapus.');
    }
}