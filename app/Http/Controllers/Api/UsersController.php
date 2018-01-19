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
            // Configure file name
            $fileName = "{$request->user()->id}/{$file->hashName()}";
            // Store file into disk
            $file->storePubliclyAs('uploads', $fileName);
            // Persist to database
            $image = Image::create([
                'title'       => $request->input('title') ?? '',
                'description' => $request->input('description') ?? '',
                'location'    => $fileName
            ]);

            return $this->successResponse(compact('image'));
        }

        return $this->errorResponse();
    }
}