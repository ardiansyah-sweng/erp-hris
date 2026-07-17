<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobrole extends Model
{
    use HasFactory;

    protected $table = 'job_roles';

    protected $fillable = [
        'role',
        'department_id',
        'level_id',
        'status_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}