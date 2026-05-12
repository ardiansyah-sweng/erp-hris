<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    use HasFactory;
     protected $fillable = [ 'role'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    
    protected $table = 'job_roles';
}