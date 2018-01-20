<?php

namespace StreetWorks\Http\Controllers\Api;

use Storage;
use Illuminate\Http\Request;
use StreetWorks\Models\User;
use StreetWorks\Models\Avatar;
use Illuminate\Http\UploadedFile;
use StreetWorks\Http\Controllers\Controller;
use StreetWorks\Http\Requests\AvatarRequest;
use StreetWorks\Http\Requests\ProfileRequest;
use StreetWorks\Http\Requests\PasswordRequest;
use StreetWorks\Http\Requests\BusinessInfoRequest;

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
                'source' => url(Avatar::PATH . '/' . $fileName)
            ]);
        }

        return $this->errorResponse();
    }

    /**
     * Upload cover image.
     *
     * @param Request $request
     *
     * @return array
     */
    public function uploadCoverImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image'
        ]);

        $file = $request->file('image');

        if ($file instanceof UploadedFile) {
            $image = $request->user()->storeImage($file, [
                'title'       => '',
                'description' => 'Cover photo'
            ]);
            $request->user()->cover_image_id = $image->id;
            $request->user()->save();

            return $this->successResponse(compact('image'));
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

    /**
     * Show profile for a user.
     *
     * @param User $user
     *
     * @return array
     */
    public function profile(User $user)
    {
        return $this->successResponse(compact('user'));
    }

    /**
     * Get user's business info.
     *
     * @param User $user
     *
     * @return array
     */
    public function getBusinessInfo(User $user)
    {
        if ($user->is_business) {
            $info = $user->businessInfo;

            return $this->successResponse(compact('info'));
        }

        return $this->errorResponse('No business info');
    }

    /**
     * Create business info for user.
     *
     * @param BusinessInfoRequest $request
     *
     * @return array
     */
    public function createBusinessInfo(BusinessInfoRequest $request)
    {
        try {
            $request->user()->createBusinessInfo($request->all());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }

    /**
     * Update business info for user.
     *
     * @param BusinessInfoRequest $request
     *
     * @return array
     */
    public function updateBusinessInfo(BusinessInfoRequest $request)
    {
        try {
            $request->user()->updateBusinessInfo($request->all());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }
}