<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    use HasFactory;

    protected $table = 'reimbursements';

    public const CATEGORIES = [
        'transport' => 'Transport',
        'medical'   => 'Medical',
        'meal'      => 'Uang Makan',
        'training'  => 'Training',
        'other'     => 'Lain-lain',
    ];

    protected $fillable = [
        'employee_id',
        'category',
        'title',
        'description',
        'amount',
        'receipt_path',
        'submission_date',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount'          => 'double',
        'submission_date' => 'date',
        'approved_at'     => 'datetime',
    ];

    /**
     * Karyawan pemilik klaim.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * User yang meng-approve klaim.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: hanya klaim yang approved.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: hanya klaim yang pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Label kategori yang readable.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
