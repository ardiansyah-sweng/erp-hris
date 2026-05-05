<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    use HasFactory;
<<<<<<< HEAD

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_roles';
=======
    
    protected $table = 'job_roles';

    protected $fillable = [
        'role'
    ];
>>>>>>> 6054f43c175f5e91ec8c3d0c7a413cc581895e3e
}