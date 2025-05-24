<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Development',
                'description' => 'Software development team',
            ],
            [
                'name' => 'Design',
                'description' => 'UI/UX design team',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Marketing and communications team',
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
} 