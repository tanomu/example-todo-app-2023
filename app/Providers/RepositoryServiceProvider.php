<?php

namespace App\Providers;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(TaskRepositoryContract::class, TaskRepository::class);
    }

    public function boot(): void
    {
    }
}
