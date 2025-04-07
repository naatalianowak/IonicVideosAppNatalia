<?php

namespace App\Providers;

use App\Models\Multimedia;
use App\Policies\MultimediaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Video;
use App\Policies\VideoPolicy;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-videos', function ($user) {
            return $user->isSuperAdmin();
        });

        Gate::define('view-videos', function ($user) {
            return $user->hasPermissionTo('view videos');
        });

        Blade::component('layouts.app', 'layouts.app');
    }

    protected $policies = [
        Multimedia::class => MultimediaPolicy::class,
        Video::class => VideoPolicy::class,
    ];
}
