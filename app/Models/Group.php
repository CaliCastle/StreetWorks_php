<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Traits\UUIDs;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use UUIDs;

    /**
     * Set incrementing to false, because we're using UUIDs.
     *
     * @var bool
     */
    public $incrementing = false;
}
