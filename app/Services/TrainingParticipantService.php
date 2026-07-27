<?php

namespace App\Services;

use App\Models\Training;
use App\Models\TrainingParticipant;

class TrainingParticipantService
{
    public function getParticipants($trainingId)
    {
        return TrainingParticipant::with('employee')
            ->where('training_id', $trainingId)
            ->get();
    }

    public function addParticipant($trainingId, $employeeId)
    {
        return TrainingParticipant::firstOrCreate([
            'training_id' => $trainingId,
            'employee_id' => $employeeId,
        ]);
    }

    public function updateAttendance($participantId, $status)
    {
        $participant = TrainingParticipant::findOrFail($participantId);

        $participant->update([
            'attendance_status' => $status,
        ]);

        return $participant;
    }

    public function removeParticipant($participantId)
    {
        $participant = TrainingParticipant::findOrFail($participantId);
        $participant->delete();
        return $participant;
    }
}