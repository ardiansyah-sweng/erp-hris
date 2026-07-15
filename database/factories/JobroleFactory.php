<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobRoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'role'       => $this->faker->jobTitle(),
            'department' => $this->faker->randomElement(['IT', 'Data', 'Human Resources', 'Product']),
            'level'      => $this->faker->randomElement(['Staff', 'Senior', 'Manager']),
            'status'     => $this->faker->randomElement(['Active', 'On Leave']),
        ];
    }
}