<?php

namespace StreetWorks\Models;

use StreetWorks\Library\Model;

class Comment extends Model
{
    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = ['text', 'post_id', 'user_id', 'image_id'];

    /**
     * Whose comment.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The post it belongs to.
     *
     * @return mixed
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
