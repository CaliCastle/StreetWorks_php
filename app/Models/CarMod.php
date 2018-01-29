<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;

class CarMod extends Model
{
    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type', 'image_id', 'installed_at'
    ];

    /**
     * Date attributes.
     *
     * @var array
     */
    protected $dates = ['installed_at'];

    /**
     * Mod's car.
     *
     * @return mixed
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Mod's image.
     *
     * @return mixed
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
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
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'image'   => $this->image
        ]);
    }
}
