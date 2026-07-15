<?php

namespace Database\Factories;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateOfBirth = fake()->dateTimeBetween('-60 years', '-18 years');
        $age = (int) Carbon::parse($dateOfBirth)->age;

        static $counter = 0;
        $counter++;

        return [
            'employee_code' => 'EMP' . str_pad($counter, 3, '0', STR_PAD_LEFT),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => $dateOfBirth,
            'address' => fake()->address(),
            'id_number' => fake()->numerify('##########'),
            'age' => $age,
            'role_id' => fake()->numberBetween(1, 5),
        ];
    }
}
