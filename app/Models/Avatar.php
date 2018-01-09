<?php

namespace StreetWorks\Models;

use Illuminate\Database\Eloquent\Model;

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
}
