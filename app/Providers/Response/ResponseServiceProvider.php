<?php

namespace App\Providers\Response;

use App\Contracts\Response\ResponseContract;
use App\Services\Response\JSONResponseService;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResponseContract::class, JSONResponseService::class);
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
