<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function jobRoles()
    {
        return $this->hasMany(Jobrole::class);
    }
}
