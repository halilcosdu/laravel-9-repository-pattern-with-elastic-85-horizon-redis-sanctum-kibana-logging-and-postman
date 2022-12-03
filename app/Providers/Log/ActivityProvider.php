<?php

namespace App\Providers\Log;

use App\Contracts\Log\ActivityContract;
use App\Contracts\Log\User\ActivityContract as UserActivityContract;
use App\Repositories\ES\Log\ActivityRepository;
use App\Services\Log\ActivityService;
use Illuminate\Support\ServiceProvider;

class ActivityProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActivityContract::class, ActivityService::class);
        $this->app->singleton(UserActivityContract::class, ActivityRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
