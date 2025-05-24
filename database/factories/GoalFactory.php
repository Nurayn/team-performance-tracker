<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'team_id' => Team::factory(),
            'assigned_to' => null,
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(array_keys(Goal::STATUSES)),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }

    public function assigned(): static
    {
        return $this->state(function (array $attributes) {
            $team = Team::find($attributes['team_id']);
            if (!$team) {
                return ['assigned_to' => null];
            }
            
            $teamMember = $team->users()->role('team-member')->first();
            return [
                'assigned_to' => $teamMember?->id,
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
} 