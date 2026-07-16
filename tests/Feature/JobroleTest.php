<?php

namespace Tests\Feature;

use App\Models\Jobrole;
use App\Models\User;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class JobroleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_job_roles_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('job_roles'));
    }

    public function test_job_roles_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('job_roles', [
            'id', 'role', 'department_id', 'level_id', 'status', 'created_at', 'updated_at',
        ]));
    }

    public function test_create_jobrole_successfully(): void
    {
        $payload = ['name' => 'Software Engineer'];

        $response = $this->postJson('/test-jobrole', $payload);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Data berhasil disimpan']);

        $this->assertDatabaseHas('job_roles', [
            'role' => 'Software Engineer',
        ]);
    }

    public function test_delete_jobrole_successfully(): void
    {
        $jobrole = Jobrole::create(['role' => 'Quality Assurance']);

        $response = $this->withoutMiddleware()->deleteJson("/job-roles/{$jobrole->id}");

        $response->assertStatus(200)
            ->assertJson(['payload' => ['statusCode' => 200, 'message' => 'Job role deleted successfully!']]);

        $this->assertDatabaseMissing('job_roles', ['id' => $jobrole->id]);
    }

    public function test_index_jobrole_view(): void
    {
        $this->actingAs(User::factory()->create());

        $dept = Department::create(['name' => 'IT']);
        $lvl = Level::create(['name' => 'Staff']);
        Jobrole::create(['role' => 'Software Engineer', 'department_id' => $dept->id, 'level_id' => $lvl->id, 'status' => 'Active']);

        $response = $this->get('/job-roles');

        $response->assertStatus(200);
        $response->assertViewIs('job_role.index');
        $response->assertViewHas('jobroles');
        $response->assertSee('Software Engineer');
    }

    public function test_show_jobrole_view(): void
    {
        $this->actingAs(User::factory()->create());

        $jobrole = Jobrole::create(['role' => 'Software Engineer']);

        $response = $this->get("/job-roles/{$jobrole->id}");

        $response->assertStatus(200);
        $response->assertViewIs('job_role.detail');
        $response->assertViewHas('jobrole');
        $response->assertSee('Software Engineer');
    }

    public function test_edit_jobrole_view(): void
    {
        $this->actingAs(User::factory()->create());

        Department::create(['name' => 'IT']);
        Level::create(['name' => 'Staff']);
        $jobrole = Jobrole::create(['role' => 'Data Analyst']);

        $response = $this->get(route('jobrole.edit', $jobrole->id));

        $response->assertStatus(200);
        $response->assertViewIs('job_role.edit');
        $response->assertViewHas('jobrole');
        $response->assertSee('Data Analyst');
    }

    public function test_update_jobrole_successfully(): void
    {
        $this->actingAs(User::factory()->create());

        $jobrole = Jobrole::create(['role' => 'Old Role']);

        $response = $this->put(route('jobrole.update', $jobrole->id), [
            'name' => 'Updated Role',
        ]);

        $response->assertRedirect(route('jobrole.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('job_roles', [
            'id' => $jobrole->id,
            'role' => 'Updated Role',
        ]);
    }

    public function test_update_jobrole_validation_fails(): void
    {
        $this->actingAs(User::factory()->create());

        $jobrole = Jobrole::create(['role' => 'Some Role']);

        $response = $this->put(route('jobrole.update', $jobrole->id), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }
}