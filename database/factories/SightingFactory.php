<?php

namespace Database\Factories;

use App\Enums\SightingTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sighting>
 */
class SightingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(SightingTypeEnum::values()),
            'when' => now()->format('Y-m-d H:i:s'),
            'latitude' => fake()->randomFloat(6, -90, 90),
            'longitude' => fake()->randomFloat(6, -180, 180),
            'notes' => fake()->name(),
            'image_url' => fake()->url(),
            'user_id' => User::factory(), // fake()->numberBetween(1,2)
        ];
    }
}
