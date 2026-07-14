<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\PerformanceEvaluation;
use App\Models\User;
use Tests\TestCase;

class PerformanceEvaluationControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function sampleCriteriaScores(): array
    {
        return [
            'kedisiplinan' => 4,
            'kualitas_kerja' => 5,
            'kerjasama_tim' => 4,
            'inisiatif' => 3,
            'tanggung_jawab' => 4,
        ]; // rata-rata = 4
    }

    public function test_index_page_displays_performance_evaluations(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();
        PerformanceEvaluation::create([
            'employee_id' => $employee->id,
            'evaluator_id' => $user->id,
            'evaluation_date' => '2026-07-01',
            'score' => 4,
            'feedback' => 'Bagus',
            'criteria_scores' => $this->sampleCriteriaScores(),
        ]);

        $response = $this->actingAs($user)->get(route('evaluations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('evaluations.index');
        $response->assertViewHas('evaluations');
    }

    public function test_guest_can_create_performance_evaluation(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->post(route('evaluations.store'), [
            'employee_id' => $employee->id,
            'evaluation_date' => '2026-07-02',
            'feedback' => 'Kinerja baik',
            'criteria_scores' => $this->sampleCriteriaScores(),
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('performance_evaluations', [
            'employee_id' => $employee->id,
            'evaluator_id' => null,
            'score' => 4, // hasil otomatis dari rata-rata kriteria
        ]);
    }

    public function test_user_can_create_performance_evaluation(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->post(route('evaluations.store'), [
            'employee_id' => $employee->id,
            'evaluation_date' => '2026-07-02',
            'feedback' => 'Kinerja baik',
            'criteria_scores' => $this->sampleCriteriaScores(),
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('performance_evaluations', [
            'employee_id' => $employee->id,
            'evaluator_id' => $user->id,
            'score' => 4, // hasil otomatis dari rata-rata kriteria
        ]);
    }

    public function test_user_can_update_performance_evaluation(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();
        $evaluation = PerformanceEvaluation::create([
            'employee_id' => $employee->id,
            'evaluator_id' => $user->id,
            'evaluation_date' => '2026-07-01',
            'score' => 3,
            'feedback' => 'Perlu ditingkatkan',
            'criteria_scores' => $this->sampleCriteriaScores(),
        ]);

        $response = $this->actingAs($user)->put(route('evaluations.update', $evaluation), [
            'employee_id' => $employee->id,
            'evaluation_date' => '2026-07-03',
            'feedback' => 'Sangat Baik',
            'criteria_scores' => [
                'kedisiplinan' => 5,
                'kualitas_kerja' => 5,
                'kerjasama_tim' => 5,
                'inisiatif' => 5,
                'tanggung_jawab' => 5,
            ], // rata-rata = 5
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $this->assertDatabaseHas('performance_evaluations', [
            'id' => $evaluation->id,
            'score' => 5, // hasil otomatis dari rata-rata kriteria
            'feedback' => 'Sangat Baik',
        ]);
    }

    public function test_user_can_delete_performance_evaluation(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();
        $evaluation = PerformanceEvaluation::create([
            'employee_id' => $employee->id,
            'evaluator_id' => $user->id,
            'evaluation_date' => '2026-07-01',
            'score' => 3,
            'feedback' => 'Cukup',
            'criteria_scores' => $this->sampleCriteriaScores(),
        ]);

        $response = $this->actingAs($user)->delete(route('evaluations.destroy', $evaluation));

        $response->assertRedirect(route('evaluations.index'));
        $this->assertDatabaseMissing('performance_evaluations', [
            'id' => $evaluation->id,
        ]);
    }
}