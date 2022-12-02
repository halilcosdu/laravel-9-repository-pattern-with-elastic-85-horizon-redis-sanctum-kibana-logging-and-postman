<?php

namespace App\Traits;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder  $query
     * @param  QueryFilters  $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
