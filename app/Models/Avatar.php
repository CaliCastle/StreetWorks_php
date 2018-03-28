<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;

class Avatar extends Model
{
    /**
     * Custom table name.
     *
     * @var string
     */
    protected $table = 'user_avatars';

    /**
     * The local type lookup.
     */
    const LOCAL = 0;

    /**
     * The remote type lookup.
     */
    const REMOTE = 1;

    /**
     * The path for avatars.
     */
    const PATH = 'avatars';

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'source', 'type'
    ];

    /**
     * Belongs to whom.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get url attribute.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string|null
     */
    public function getUrlAttribute()
    {
        return isset($this->source) ? url('avatars/' . $this->source) : null;
    }
}
