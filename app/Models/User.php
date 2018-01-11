<?php

namespace StreetWorks\Models;

use Laravel\Passport\HasApiTokens;
use StreetWorks\Library\Traits\UUIDs;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UUIDs, HasApiTokens;

    /**
     * Set incrementing to false, because we're using UUIDs.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User's avatar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    /**
     * User's cars.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * User's posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * User's liked posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'posts_likes');
    }

    /**
     * User's comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * User's business info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function businessInfo()
    {
        return $this->hasOne(BusinessInfo::class);
    }

    /**
     * Update attributes automatically.
     *
     * @param array $attributes
     */
    public function updateAttributes($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (! is_null($this->{$key})) {
                $this->{$key} = $value;
            }
        }

        if ($this->isDirty())
            $this->save();
    }

    /**
     * Change user's password.
     *
     * @param string $password
     */
    public function changePassword($password = '')
    {
        $this->password = bcrypt($password);
        $this->save();
    }

    /**
     * Toggle like on a post.
     *
     * @param Post $post
     */
    public function likeOrUnlike(Post $post)
    {
        $this->likedPosts()->toggle([$post->id]);
    }

    /**
     * Create user's business info.
     *
     * @param array $attributes
     * @throws \Exception
     */
    public function createBusinessInfo($attributes = [])
    {
        if (! is_null($this->businessInfo))
            throw new \Exception('Already have business info');

        $this->businessInfo()->create($attributes);

        $this->is_business = true;
        $this->save();
    }

    /**
     * Update user's business info.
     *
     * @param array $attributes
     *
     * @throws \Exception
     */
    public function updateBusinessInfo($attributes = [])
    {
        if (is_null($this->businessInfo))
            throw new \Exception('No business info found');

        $this->businessInfo()->update($attributes);
    }
}
