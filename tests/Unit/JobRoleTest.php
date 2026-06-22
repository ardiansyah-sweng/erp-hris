<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class JobRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the job_roles table exists after migration.
     */
    public function test_job_roles_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('job_roles'));
    }

    /**
     * Test that the job_roles table has all required columns.
     */
    public function test_job_roles_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('job_roles', [
            'id',
            'role',
            'created_at',
            'updated_at',
        ]));
    }
}