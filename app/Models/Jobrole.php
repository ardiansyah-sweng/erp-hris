<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobrole extends Model
{
    use HasFactory;

    protected $table = 'job_roles';

    protected $fillable = [
        'role'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'role_id');
    }
}