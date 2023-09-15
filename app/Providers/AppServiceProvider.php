<?php

namespace App\Providers;

use App\TaskManagers\Local\LocalTaskManager;
use App\TaskManagers\Redmine\RedmineTaskManager;
use App\TaskManagers\TaskManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskManager::class, function (Application $app) {
            return config('task_storage.default') == 'redmine'
                ? new RedmineTaskManager()
                : new LocalTaskManager();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
