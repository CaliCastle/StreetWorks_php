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
        return $this->belongsTo(Image::class);
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

    /**
     * Comments of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get readable time ago info.
     *
     * @return string
     */
    public function readableTimeAgo()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), $this->apiAttributes());
    }

    /**
     * Extra api attributes for feed.
     *
     * @return array
     */
    protected function apiAttributes()
    {
        $primaryCar = $this->user->primaryCar();

        return [
            'image_url'    => $this->image->url,
            'image_aspect' => $this->image->aspectRatio(),
            'time_ago'     => $this->readableTimeAgo(),
            'user'         => [
                'username'  => $this->user->username,
                'avatar'    => optional($this->user->avatar)->url,
                'car_model' => optional($primaryCar)->fullName(),
                'car_image' => optional(optional($primaryCar)->image)->url
            ],
            'meta'         => [
                'likes'    => $this->likes()->count(),
                'comments' => $this->comments()->count()
            ]
        ];
    }
}