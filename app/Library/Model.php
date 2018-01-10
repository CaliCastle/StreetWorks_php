<?php

namespace StreetWorks\Library;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    /**
     * Get table name.
     *
     * @return mixed
     */
    public static function table()
    {
        $instance = new static;

        return $instance->getTable();
    }
}