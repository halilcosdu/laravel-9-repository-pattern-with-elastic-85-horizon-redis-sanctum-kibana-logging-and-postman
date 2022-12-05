<?php

namespace App\Repositories\ES;

interface RepositoryInterface
{
    /**
     * @return $this
     */
    public function connectCluster();

    /**
     * @return string
     */
    public static function getIndex();
}
