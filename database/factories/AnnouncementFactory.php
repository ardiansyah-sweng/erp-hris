<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'title'        => $this->faker->sentence(4),
            'content'      => $this->faker->paragraphs(3, true),
            'publish_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'status'       => $this->faker->randomElement(['Aktif', 'Draft']),
        ];
    }

    public function aktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Aktif',
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Draft',
        ]);
    }
}
