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
            'score' => 4,
            'feedback' => 'Kinerja baik',
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('performance_evaluations', [
            'employee_id' => $employee->id,
            'evaluator_id' => null,
            'score' => 4,
        ]);
    }

    public function test_user_can_create_performance_evaluation(): void
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->post(route('evaluations.store'), [
            'employee_id' => $employee->id,
            'evaluation_date' => '2026-07-02',
            'score' => 4,
            'feedback' => 'Kinerja baik',
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('performance_evaluations', [
            'employee_id' => $employee->id,
            'evaluator_id' => $user->id,
            'score' => 4,
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
        ]);

        $response = $this->actingAs($user)->put(route('evaluations.update', $evaluation), [
            'employee_id' => $employee->id,
            'evaluation_date' => '2026-07-03',
            'score' => 5,
            'feedback' => 'Sangat Baik',
        ]);

        $response->assertRedirect(route('evaluations.index'));
        $this->assertDatabaseHas('performance_evaluations', [
            'id' => $evaluation->id,
            'score' => 5,
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
        ]);

        $response = $this->actingAs($user)->delete(route('evaluations.destroy', $evaluation));

        $response->assertRedirect(route('evaluations.index'));
        $this->assertDatabaseMissing('performance_evaluations', [
            'id' => $evaluation->id,
        ]);
    }
}