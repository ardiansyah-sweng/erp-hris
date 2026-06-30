<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 5) . ' days');

        return [
            'employee_id' => 'EMP' . $this->faker->unique()->numberBetween(100, 999),
            'employee_name' => $this->faker->name(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'reason' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'submission_date' => now()->format('Y-m-d'),
        ];
    }
}
