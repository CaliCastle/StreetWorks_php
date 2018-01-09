<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Traits\UUIDs;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use UUIDs;

    /**
     * Set incrementing to false, because we're using UUIDs.
     *
     * @var bool
     */
    protected $incrementing = false;

}
