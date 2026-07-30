<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingParticipant;
use App\Services\TrainingParticipantService;
use Illuminate\Http\Request;

class TrainingParticipantController extends Controller
{
    protected $participantService;

    public function __construct(TrainingParticipantService $participantService)
    {
        $this->participantService = $participantService;
    }

    public function index(Training $training)
    {
        $participants = $this->participantService->getParticipants($training->id);

        // Karyawan yang belum terdaftar di training ini (untuk pilihan di form tambah)
        $registeredIds = $participants->pluck('employee_id');
        $availableEmployees = Employee::whereNotIn('id', $registeredIds)
            ->orderBy('name')
            ->get();

        return view('training.participants', compact('training', 'participants', 'availableEmployees'));
    }

    public function store(Request $request, Training $training)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $this->participantService->addParticipant($training->id, $validated['employee_id']);

        return redirect()
            ->route('training.participants.index', $training->id)
            ->with('success', 'Karyawan berhasil didaftarkan ke training.');
    }

    public function updateAttendance(Request $request, TrainingParticipant $participant)
    {
        $validated = $request->validate([
            'attendance_status' => 'required|in:Registered,Attended,Absent',
        ]);

        $this->participantService->updateAttendance($participant->id, $validated['attendance_status']);

        return redirect()
            ->route('training.participants.index', $participant->training_id)
            ->with('success', 'Status kehadiran berhasil diperbarui.');
    }

    public function destroy(TrainingParticipant $participant)
    {
        $trainingId = $participant->training_id;

        $this->participantService->removeParticipant($participant->id);

        return redirect()
            ->route('training.participants.index', $trainingId)
            ->with('success', 'Peserta berhasil dihapus dari training.');
    }
}