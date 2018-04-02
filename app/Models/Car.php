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
        'name', 'manufacturer', 'model', 'year', 'license', 'description', 'image_id', 'primary', 'specs', 'hashtags'
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
     * Car's cover image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coverImage()
    {
        return $this->hasOne(Image::class, 'id', 'cover_image_id');
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
            'image'       => $this->image,
            'cover_image' => $this->coverImage,
            'user'        => $this->user,
            'primary'     => $this->primary ? 1 : 0
        ]);
    }

    /**
     * Set primary first order.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePrimaryFirst($query)
    {
        return $query->orderBy('primary', 'desc');
    }

    /**
     * Set latest first order.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * Get car full name.
     *
     * @return string
     */
    public function fullName()
    {
        return $this->year . ' ' . $this->manufacturer . ' ' . $this->model;
    }
}
