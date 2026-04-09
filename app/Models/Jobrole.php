<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobrole extends Model
{
    use HasFactory;
    
    protected $table = 'jobroles';

    protected $fillable = [
        'name',
        'description',
    ];
}