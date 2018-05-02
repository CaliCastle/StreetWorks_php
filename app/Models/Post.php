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
    protected $fillable = ['text', 'image_id', 'car_id'];

    protected $perPage = 30;

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
     * Car of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
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
        $currentUser = auth()->user();

        return [
            'image_url'    => $this->image->url,
            'image_aspect' => $this->image->aspectRatio(),
            'time_ago'     => $this->readableTimeAgo(),
            'user'         => [
                'id'        => $this->user->id,
                'username'  => $this->user->username,
                'avatar'    => optional($this->user->avatar)->url,
                'car_model' => optional($this->car)->fullName(),
                'car_image' => optional($this->car->image)->url
            ],
            'meta'         => [
                'likes'    => $this->likes()->count(),
                'comments' => $this->comments()->count(),
                'liked'    => $this->likes()->where('user_id', optional($currentUser)->id)->exists()
            ]
        ];
    }
}