<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;
use StreetWorks\Library\Traits\UUIDs;

class Image extends Model
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
    protected $fillable = ['title', 'description', 'location'];
}
