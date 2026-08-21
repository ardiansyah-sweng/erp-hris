<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'role_id',
        'apply_date',
        'cv',
        'status',
        'notes',
    ];

    public function jobrole()
    {
        return $this->belongsTo(Jobrole::class, 'role_id');
    }
}