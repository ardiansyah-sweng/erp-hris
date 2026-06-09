<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jobrole;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'place_of_birth',
        'date_of_birth',
        'address',
        'id_number',
        'age',
        'role_id',
    ];

    public function jobrole()
    {
        return $this->belongsTo(Jobrole::class, 'role_id');
    }
}