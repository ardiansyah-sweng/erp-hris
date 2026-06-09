<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpha']),
            'check_in' => $this->faker->time('H:i'),
            'check_out' => $this->faker->time('H:i'),
            'notes' => $this->faker->sentence(),
        ];
    }
}