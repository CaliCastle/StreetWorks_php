<?php

namespace StreetWorks\Models;

use Storage;
use StreetWorks\Library\Model;
use StreetWorks\Library\Traits\UUIDs;

class Image extends Model
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
    protected $fillable = ['title', 'description', 'location'];

    /**
     * Get url attribute.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        return url('uploads/' . $this->location);
    }

    /**
     * Get image's aspect ratio.
     *
     * @return float|int
     */
    public function aspectRatio()
    {
        list($width, $height) = getimagesize(storage_path('app/uploads/' . $this->location));

        return $width / $height;
    }

    /**
     * Completely remove an image.
     *
     * @throws \Exception
     */
    public function moveToTrash()
    {
        Storage::delete('uploads/' . $this->location);

        $this->delete();
    }
}
