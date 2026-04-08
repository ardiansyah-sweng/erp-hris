<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test job_roles table is created
     */
    public function test_job_roles_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('job_roles'));
    }

    /**
     * Test job_roles table has correct columns
     */
    public function test_job_roles_table_has_correct_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('job_roles', [
            'id',
            'role',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test job_roles role column is string
     */
    public function test_job_roles_role_column_is_string(): void
    {
        $columns = Schema::getColumns('job_roles');
        $roleColumn = collect($columns)->firstWhere('name', 'role');

        $this->assertNotNull($roleColumn);
        $this->assertStringContainsString('varchar', $roleColumn['type']);
    }
}
