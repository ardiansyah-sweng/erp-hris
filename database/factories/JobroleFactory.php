<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobRoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'role' => $this->faker->jobTitle(),
        ];
    }
}