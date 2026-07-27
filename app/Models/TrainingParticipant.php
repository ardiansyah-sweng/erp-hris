<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingParticipant extends Model
{
    protected $fillable = [
        'training_id',
        'employee_id',
        'attendance_status',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}