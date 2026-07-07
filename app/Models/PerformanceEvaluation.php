<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceEvaluation extends Model
{
    use HasFactory;

    
    public const CRITERIA = [
        'kedisiplinan'   => 'Kedisiplinan',
        'kualitas_kerja' => 'Kualitas Kerja',
        'kerjasama_tim'  => 'Kerjasama Tim',
        'inisiatif'      => 'Inisiatif',
        'tanggung_jawab' => 'Tanggung Jawab',
    ];

    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'evaluation_date',
        'score',
        'feedback',
        'criteria_scores',
    ];

    protected $casts = [
        'criteria_scores' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    // Rata-rata skor kriteria (opsional, dipakai di index kalau perlu)
    public function getCriteriaAverageAttribute(): ?float
    {
        if (empty($this->criteria_scores)) {
            return null;
        }

        return round(array_sum($this->criteria_scores) / count($this->criteria_scores), 2);
    }
}