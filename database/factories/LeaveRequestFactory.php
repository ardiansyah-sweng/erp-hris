<?php

namespace Database\Factories;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 days', '+1 month');
        $endDate = (clone $startDate)->modify('+' . rand(1, 5) . ' days');

        return [
            'employee_id'     => 'EMP' . str_pad(fake()->numberBetween(1, 20), 3, '0', STR_PAD_LEFT),
            'employee_name'   => fake()->name(),
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'reason'          => fake()->sentence(),
            'status'          => fake()->randomElement(['Pending', 'Approved', 'Rejected']),
            'submission_date' => fake()->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
