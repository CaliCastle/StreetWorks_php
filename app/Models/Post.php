<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;

class Post extends Model
{
    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = ['text', 'image_id'];

    /**
     * The user it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The image it owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(Image::class);
    }

    /**
     * Likes of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'posts_likes');
    }
}