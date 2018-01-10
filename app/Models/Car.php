<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Traits\UUIDs;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use UUIDs;

    /**
     * Set incrementing to false, because we're using UUIDs.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'make', 'model', 'model_year', 'license'
    ];
}
