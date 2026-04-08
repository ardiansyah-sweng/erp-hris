<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the employees table exists after migration.
     */
    public function test_employees_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('employees'));
    }

    /**
     * Test that the employees table has all required columns.
     */
    public function test_employees_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasColumns('employees', [
            'id',
            'name',
            'email',
            'phone_number',
            'place_of_birth',
            'date_of_birth',
            'address',
            'id_number',
            'age',
            'role_id',
            'created_at',
            'updated_at',
        ]));
    }
}