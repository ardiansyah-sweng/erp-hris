<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'trainer',
        'department_id',
        'location',
        'training_date',
        'status',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}