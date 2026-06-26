<?php

namespace Database\Seeders;

use App\Models\Scenario;
use Illuminate\Database\Seeder;

class ScenarioSeeder extends Seeder
{
    public function run(): void
    {
        Scenario::updateOrCreate(
            ['slug' => 'git-init'],
            [
                'title' => 'Initialize Git Repository',
                'description' => 'Initialize a git repository, create README file, add files, and make initial commit.',
                'difficulty' => 'easy',
                'type' => 'git',
            ]
        );
        Scenario::updateOrCreate(
            ['slug' => 'git-branch-create'],
            [
                'title' => 'Create Git Branch',
                'description' => 'Create a new git branch and switch to it.',
                'difficulty' => 'easy',
                'type' => 'git',
            ]
        );
    }
}