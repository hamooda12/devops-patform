<?php

namespace Database\Seeders;

use App\Models\Scenario;
use Illuminate\Database\Seeder;

class ScenarioSeeder extends Seeder
{
    public function run(): void
    {
       Scenario::create([
    'title' => 'Initialize Git Repository',
    'slug' => 'git-init',
    'description' => 'Initialize a git repository, create README file, add files, and make initial commit.',
    'difficulty' => 'easy',
]);
    }
}