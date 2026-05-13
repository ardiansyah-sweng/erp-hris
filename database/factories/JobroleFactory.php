<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jobrole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jobrole>
 */
class JobroleFactory extends Factory
{
    protected $model = Jobrole::class;

    public function definition(): array
    {
        return [
            'role' => $this->faker->jobTitle(),
        ];
    }
}