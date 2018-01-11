<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;

class BusinessInfo extends Model
{
    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = ['description', 'address_1', 'address_2', 'address_3', 'city', 'state', 'country', 'phone', 'email'];

    /**
     * The user it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
