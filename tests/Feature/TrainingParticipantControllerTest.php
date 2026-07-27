<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingParticipant;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTruncation;

class TrainingParticipantControllerTest extends TestCase
{
    use DatabaseTruncation;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function createTraining(): Training
    {
        return Training::create([
            'title' => 'Pelatihan Laravel Dasar',
            'trainer' => 'Budi Santoso',
            'location' => 'Ruang Meeting A',
            'training_date' => '2026-08-01',
            'status' => 'Scheduled',
            'description' => 'Pelatihan dasar framework Laravel',
        ]);
    }

    public function test_index_page_displays_participants(): void
    {
        $user = User::factory()->create();
        $training = $this->createTraining();
        $employee = Employee::factory()->create();

        TrainingParticipant::create([
            'training_id' => $training->id,
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($user)->get(route('training.participants.index', $training->id));

        $response->assertStatus(200);
        $response->assertViewIs('training.participants');
        $response->assertViewHas('participants');
    }

    public function test_user_can_add_participant_to_training(): void
    {
        $user = User::factory()->create();
        $training = $this->createTraining();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->post(route('training.participants.store', $training->id), [
            'employee_id' => $employee->id,
        ]);

        $response->assertRedirect(route('training.participants.index', $training->id));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('training_participants', [
            'training_id' => $training->id,
            'employee_id' => $employee->id,
            'attendance_status' => 'Registered',
        ]);
    }

    public function test_cannot_add_duplicate_participant(): void
    {
        $user = User::factory()->create();
        $training = $this->createTraining();
        $employee = Employee::factory()->create();

        TrainingParticipant::create([
            'training_id' => $training->id,
            'employee_id' => $employee->id,
        ]);

        $this->actingAs($user)->post(route('training.participants.store', $training->id), [
            'employee_id' => $employee->id,
        ]);

        // Harus tetap cuma ada 1 baris, tidak boleh duplikat
        $this->assertDatabaseCount('training_participants', 1);
    }

    public function test_user_can_update_attendance_status(): void
    {
        $user = User::factory()->create();
        $training = $this->createTraining();
        $employee = Employee::factory()->create();

        $participant = TrainingParticipant::create([
            'training_id' => $training->id,
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($user)->put(route('training.participants.update', $participant->id), [
            'attendance_status' => 'Attended',
        ]);

        $response->assertRedirect(route('training.participants.index', $training->id));
        $this->assertDatabaseHas('training_participants', [
            'id' => $participant->id,
            'attendance_status' => 'Attended',
        ]);
    }

    public function test_user_can_remove_participant(): void
    {
        $user = User::factory()->create();
        $training = $this->createTraining();
        $employee = Employee::factory()->create();

        $participant = TrainingParticipant::create([
            'training_id' => $training->id,
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($user)->delete(route('training.participants.destroy', $participant->id));

        $response->assertRedirect(route('training.participants.index', $training->id));
        $this->assertDatabaseMissing('training_participants', [
            'id' => $participant->id,
        ]);
    }
}