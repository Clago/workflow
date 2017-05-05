<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Workflow\Workflow;

class WorkflowServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('workflow', function ($app) {
            return new Workflow();
        });
    }
}
