<?php

/**
 * Šī rūpnīca ģenerē "Goal Factory" testdatus.
 */

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(100),
            'type' => $this->faker->randomElement(['steps', 'calories', 'sleep', 'weight']),
            'target_value' => $this->faker->numberBetween(10, 100),
            'current_value' => $this->faker->numberBetween(0, 10),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'change' => $this->faker->numberBetween(-10, 10),
        ];
    }
}
