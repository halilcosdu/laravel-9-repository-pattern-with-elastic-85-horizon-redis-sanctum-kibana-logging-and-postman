<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserFilters
 */
class UserFilters extends QueryFilters
{
    /**
     * @param $value
     * @return Builder
     */
    public function name($value)
    {
        return $this->builder->where('name', 'LIKE', "%$value%");
    }

    /**
     * @param $value
     * @return Builder
     */
    public function email($value)
    {
        return $this->builder->where('email', 'LIKE', "%$value%");
    }
}
