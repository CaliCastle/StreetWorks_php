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

    protected $casts = [
        'specs' => 'array'
    ];

    /**
     * Spec types.
     */
    const SPEC_TYPE_ENGINE = 0;
    const SPEC_TYPE_TRANSMISSION = 1;
    const SPEC_TYPE_AERO = 2;
    const SPEC_TYPE_SUSPENSION = 3;
    const SPEC_TYPE_MISC = 4;
    const SPEC_TYPE_CUSTOM = 5;

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
        return $this->belongsTo(Image::class);
    }

    /**
     * Car's mods.
     *
     * @return mixed
     */
    public function mods()
    {
        return $this->hasMany(CarMod::class);
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'image'   => $this->image,
            'user'    => $this->user,
            'primary' => $this->primary ? 1 : 0
        ]);
    }
}
