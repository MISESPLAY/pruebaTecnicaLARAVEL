<?php

namespace App\Providers;

use App\Eloquent\Interfaces\TaskInterface\TaskInterface;
use App\Eloquent\Repository\TaskRepository;
use App\Enums\TaskStatus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskInterface::class,
            TaskRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
