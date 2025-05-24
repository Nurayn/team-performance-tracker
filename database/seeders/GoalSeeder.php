<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        // Create goals for each team
        Team::all()->each(function ($team) {
            // Get a team member for assignment
            $teamMember = $team->users()->role('team-member')->first();
            
            // Create goals with different statuses
            Goal::factory()
                ->count(2)
                ->pending()
                ->create([
                    'team_id' => $team->id,
                    'assigned_to' => $teamMember?->id,
                ]);

            Goal::factory()
                ->count(2)
                ->inProgress()
                ->create([
                    'team_id' => $team->id,
                    'assigned_to' => $teamMember?->id,
                ]);

            Goal::factory()
                ->count(1)
                ->completed()
                ->create([
                    'team_id' => $team->id,
                    'assigned_to' => $teamMember?->id,
                ]);

            Goal::factory()
                ->count(1)
                ->cancelled()
                ->create([
                    'team_id' => $team->id,
                ]);

            // Create some unassigned goals
            Goal::factory()
                ->count(2)
                ->pending()
                ->create([
                    'team_id' => $team->id,
                ]);
        });
    }
} 