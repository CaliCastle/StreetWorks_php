<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;
use StreetWorks\Library\Traits\UUIDs;

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
        'name', 'manufacturer', 'model', 'year', 'license', 'description', 'image_id', 'primary'
    ];

    /**
     * Car's user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Car's image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
