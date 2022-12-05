<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro('toSqlWithBindings', function () {
            $bindings = array_map(
                fn ($value) => is_numeric($value) ? $value : "'{$value}'",
                $this->getBindings()
            );

            return Str::replaceArray('?', $bindings, $this->toSql());
        });
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
