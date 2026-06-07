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
        $basicSalary = $this->faker->randomFloat(2, 3000000, 15000000);
        $allowances  = $this->faker->randomFloat(2, 0, 3000000);
        $deductions  = $this->faker->randomFloat(2, 0, 1000000);
        $netSalary   = $basicSalary + $allowances - $deductions;

        return [
            'employee_id'  => Employee::factory(),
            'month'        => $this->faker->numberBetween(1, 12),
            'year'         => $this->faker->numberBetween(2024, 2026),
            'basic_salary' => $basicSalary,
            'allowances'   => $allowances,
            'deductions'   => $deductions,
            'net_salary'   => $netSalary,
            'status'       => $this->faker->randomElement(['pending', 'approved', 'paid']),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'       => 'pending',
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
            'status'       => 'paid',
        ]);
    }
}