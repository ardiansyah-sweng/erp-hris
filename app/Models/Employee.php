<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

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
    
    protected $casts = [
        'date_of_birth' => 'date',
        'age' => 'integer',
    ];

    public function jobrole()
    {
        return $this->belongsTo(Jobrole::class, 'role_id');
    }

    public function scopeCashier($query)
    {
        return $query->join('job_roles', 'employees.role_id', '=', 'job_roles.id')
                     ->where('job_roles.role', 'Cashier')
                     ->select('employees.id as id_employee', 'employees.name');
                     
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }
}
