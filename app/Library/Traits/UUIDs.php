<?php

namespace StreetWorks\Library\Traits;

use Webpatser\Uuid\Uuid;

trait UUIDs
{
    /**
     * Boot when creating the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $primaryKey = $model->getKeyName();

            if (empty($model->{$primaryKey})) {
                $model->{$primaryKey} = Uuid::generate()->string;
            }
        });
    }
}