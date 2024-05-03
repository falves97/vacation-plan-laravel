<?php

namespace Database\Factories;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HolidayPlan>
 */
class HolidayPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'location' => fake()->address,
            'date' => fake()->dateTimeBetween('now', '+30 days'),
            'owner_id' => $user->id
        ];
    }
}
