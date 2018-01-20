<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Models\Image;
use Illuminate\Http\UploadedFile;
use StreetWorks\Http\Requests\PhotoRequest;
use StreetWorks\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Upload a photo.
     *
     * @param PhotoRequest $request
     *
     * @return array
     */
    public function uploadPhoto(PhotoRequest $request)
    {
        $file = $request->file('photo');

        if ($file instanceof UploadedFile) {
            $image = $request->user()->storeImage($file, [
                'title'       => '',
                'description' => ''
            ]);

            return $this->successResponse(compact('image'));
        }

        return $this->errorResponse();
    }
}