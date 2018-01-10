<?php

namespace StreetWorks\Http\Controllers\Api;

use Storage;
use Illuminate\Http\Request;
use StreetWorks\Models\Avatar;
use Illuminate\Http\UploadedFile;
use StreetWorks\Http\Controllers\Controller;
use StreetWorks\Http\Requests\AvatarRequest;
use StreetWorks\Http\Requests\ProfileRequest;
use StreetWorks\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Retrieve user profile.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Upload an avatar.
     *
     * @param AvatarRequest $request
     *
     * @return array
     */
    public function uploadAvatar(AvatarRequest $request)
    {
        $file = $request->file('avatar');

        if ($file instanceof UploadedFile) {
            // Configure file name, {user_id}_{time}.{ext}
            $fileName = $request->user()->id . '_' . time() . '.' . $file->clientExtension();
            // Save file to storage in `avatars` directory
            $file->storePubliclyAs(Avatar::PATH, $fileName);
            // Persist into database
            $attributes = [
                'source' => $fileName,
                'type'   => Avatar::LOCAL
            ];
            // Create or update
            if ($request->user()->avatar instanceof Avatar) {
                // Delete old avatar
                Storage::delete(Avatar::PATH . '/' . $request->user()->avatar->source);
                // Update to the new one
                $request->user()->avatar()->update($attributes);
            } else {
                $request->user()->avatar()->create($attributes);
            }

            return $this->successResponse([
                'source' => $fileName
            ]);
        }

        return $this->errorResponse();
    }

    /**
     * Update user's profile.
     *
     * @param ProfileRequest $request
     *
     * @return array
     */
    public function updateProfile(ProfileRequest $request)
    {
        $request->user()->updateAttributes($request->all());

        return $this->successResponse();
    }

    /**
     * Change user's password.
     *
     * @param PasswordRequest $request
     *
     * @return array
     */
    public function changePassword(PasswordRequest $request)
    {
        $request->user()->changePassword($request->get('password'));

        return $this->successResponse();
    }
}