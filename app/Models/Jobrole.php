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
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'role_id');
    }
}