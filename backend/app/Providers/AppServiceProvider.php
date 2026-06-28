<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Submission;
use App\Policies\SubmissionPolicy;
use App\Services\Docker\DockerRunnerInterface;
use App\Services\Docker\DockerCliRunner;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(
        \App\Services\Evaluators\EvaluatorFactoryInterface::class,
        \App\Services\Evaluators\EvaluatorFactory::class

    );


    $this->app->bind(DockerRunnerInterface::class, DockerCliRunner::class);

    }

    /**
     * Bootstrap any application services.
     */
    
    public function boot(): void
    {
         Gate::policy(Submission::class, SubmissionPolicy::class);
         Gate::define('viewAdminDashboard', function ($user) {
    return $user->role === 'admin';
});
    }
}
