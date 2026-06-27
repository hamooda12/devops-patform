<?php

namespace Database\Factories;

use App\Models\Scenario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scenario>
 */
class ScenarioFactory extends Factory
{
    public function definition(): array
{
    return [
        'title' => fake()->sentence(3),
        'slug' => fake()->unique()->slug(),
        'description' => fake()->paragraph(),
        'type' => 'git',
        'difficulty' => 'easy',
        'points' => 10,
    ];
}

   public function gitInit(): static
{
    return $this->state(fn () => [
        'title' => 'Initialize Git Repository',
        'slug' => 'git-init',
        'description' => 'Initialize a git repository, add files, and make an initial commit.',
        'type' => 'git',
        'difficulty' => 'easy',
        'points' => 10,
    ]);
}

    public function gitBranchCreate(): static
    {
        return $this->state(fn () => [
            'title' => 'Create Git Branch',
            'slug' => 'git-branch-create',
        ]);
    }

    public function gitMergeBranch(): static
    {
        return $this->state(fn () => [
            'title' => 'Merge Git Branch',
            'slug' => 'git-merge-branch',
        ]);
    }
}