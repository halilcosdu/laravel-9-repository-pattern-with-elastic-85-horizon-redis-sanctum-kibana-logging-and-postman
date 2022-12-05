<?php

namespace App\Providers;

use App\Exceptions\Query\SlowQueryException;
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
        if (config('app.slow_query_enabled')) {
            DB::whenQueryingForLongerThan(
                config('app.slow_query_threshold', 500),
                function (Connection $connection, QueryExecuted $event) {
                    $query = vsprintf(str_replace(['%', '?'], ['%%', '%s'], $event->sql), $event->bindings);
                    $result = sprintf('%s (%s): %s', $connection->getName(), $event->time / 1000, $query);
                    $this->sendSlowQueryToSentry($result);
                    // Notify development team with $result
                }
            );
        }
    }

    /**
     * @param  string  $result
     * @return void
     */
    private function sendSlowQueryToSentry(string $result)
    {
        if (app()->bound('sentry')) {
            app('sentry')->captureException(new SlowQueryException($result));
        }
    }
}
