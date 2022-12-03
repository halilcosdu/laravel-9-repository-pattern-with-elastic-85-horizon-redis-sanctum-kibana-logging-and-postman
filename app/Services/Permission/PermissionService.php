<?php

namespace App\Services\Permission;

use Illuminate\Pipeline\Pipeline;

/**
 *
 */
class PermissionService
{
    /**
     * @param  \Illuminate\Pipeline\Pipeline  $pipeline
     */
    public function __construct(private readonly Pipeline $pipeline)
    {
        //
    }

    /**
     * @param  array  $attributes
     * @param  array  $permissions
     * @return mixed
     */
    public function check(array $attributes, array $permissions)
    {
        return $this->pipeline->send($attributes)->through($permissions)->thenReturn();
    }
}
