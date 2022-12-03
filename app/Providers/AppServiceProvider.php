<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::whenQueryingForLongerThan(100, function (Connection $connection, QueryExecuted $event) {
            $query = vsprintf(str_replace(['%', '?'], ['%%', '%s'], $event->sql), $event->bindings);
            $result = sprintf("%s (%s): %s", $connection->getName(), $event->time / 1000, $query);

            // Notify development team with $result
        });
    }
}
