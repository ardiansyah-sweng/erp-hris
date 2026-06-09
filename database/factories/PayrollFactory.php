<?php

namespace Database\Factories;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollFactory extends Factory
{
    protected $model = Payroll::class;

    public function definition(): array
    {
        $basicSalaryByRole = [
            'Software Engineer' => 8000000,
            'Data Analyst'      => 7000000,
            'HR Manager'        => 9000000,
            'Quality Assurance' => 6000000,
            'Product Manager'   => 10000000,
        ];

        $employee    = Employee::inRandomOrder()->first() ?? Employee::factory()->create();
        $roleName    = $employee->jobrole->role ?? 'Software Engineer';
        $basicSalary = $basicSalaryByRole[$roleName] ?? 5000000;

        $allowances  = $this->faker->randomFloat(2, 0, 3000000);
        $deductions  = $this->faker->randomFloat(2, 0, 1000000);
        $netSalary   = $basicSalary + $allowances - $deductions;

        return [
            'employee_id'  => $employee->id,
            'month'        => $this->faker->numberBetween(1, 12),
            'year'         => $this->faker->numberBetween(2024, 2026),
            'basic_salary' => $basicSalary,
            'allowances'   => $allowances,
            'deductions'   => $deductions,
            'net_salary'   => $netSalary,
            'status'       => 'pending',
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
        ]);
    }
}