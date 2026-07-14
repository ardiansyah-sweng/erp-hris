<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['present', 'absent', 'late', 'sick', 'leave']);

        // Hanya yang hadir/terlambat yang punya jam masuk & keluar
        $isPresent = in_array($status, ['present', 'late']);

        return [
            'employee_id' => Employee::inRandomOrder()->value('id'),
            'date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'status' => $status,
            'check_in' => $isPresent ? $this->faker->time('H:i') : null,
            'check_out' => $isPresent ? $this->faker->time('H:i') : null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
