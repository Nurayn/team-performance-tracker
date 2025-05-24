<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('super-admin');

        // Create team leads and members for each team
        Team::all()->each(function ($team) {
            // Create team lead
            User::factory()->create([
                'name' => "Team Lead {$team->name}",
                'email' => "lead.{$team->id}@example.com",
                'password' => Hash::make('password'),
                'team_id' => $team->id,
            ])->assignRole('team-lead');

            // Create team members
            User::factory()
                ->count(3)
                ->create(['team_id' => $team->id])
                ->each(fn ($user) => $user->assignRole('team-member'));
        });
    }
} 