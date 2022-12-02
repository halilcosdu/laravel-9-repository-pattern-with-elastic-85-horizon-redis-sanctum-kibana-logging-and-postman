<?php

namespace App\Extensions\ES;

/**
 *
 */
class SQL
{
    /**
     * @return SQLBuilder
     */
    public static function extension()
    {
        return new SQLBuilder();
    }
}
