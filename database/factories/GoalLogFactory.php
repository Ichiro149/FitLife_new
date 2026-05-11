<?php

/**
 * Šī rūpnīca ģenerē "Goal Log Factory" testdatus.
 */

namespace Database\Factories;

use App\Models\Goal;
use App\Models\GoalLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalLogFactory extends Factory
{
    protected $model = GoalLog::class;

    public function definition(): array
    {
        return [
            'goal_id' => Goal::factory(),
            'change' => fake()->numberBetween(1, 10),
            'description' => fake()->sentence(),
        ];
    }
}
