<?php

namespace StreetWorks\Http\Controllers\Api;

use Hash;
use Storage;
use Illuminate\Http\Request;
use StreetWorks\Models\Image;
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
        $user = $request->user();

        return $this->successResponse([
            'user' => [
                'first_name'  => $user->first_name,
                'last_name'   => $user->last_name,
                'username'    => $user->username,
                'email'       => $user->email,
                'status'      => $user->status,
                'is_business' => $user->is_business,
                'notoriety'   => $user->notoriety,
                'website'     => $user->website,
                'description' => $user->description,
                'hashtags'    => $user->hashtags,
//                'avatar'      => $user->avatar,
                'avatar_url'  => optional($user->avatar)->url,
                'cover_image' => optional($user->coverImage)->url
            ]
        ]);
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
        $password = $request->password;

        if (Hash::check($password, $request->user()->password)) {
            $request->user()->changePassword($request->new_password);

            return $this->successResponse();
        }

        return $this->errorResponse('Incorrect password');
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

    /**
     * Use user's Facebook avatar.
     *
     * @param Request $request
     *
     * @return array
     */
    public function useFacebookAvatar(Request $request)
    {
        $source = 'https://graph.facebook.com/v2.5/' . $request->user()->facebook_id . '/picture?width=800';

        if ($request->user()->avatar instanceof Avatar) {
            $request->user()->avatar()->update([
                'source' => $source,
                'type'   => Avatar::REMOTE
            ]);
        } else {
            $request->user()->avatar()->create([
                'source' => $source,
                'type'   => Avatar::REMOTE
            ]);
        }

        return $this->successResponse(compact('source'));
    }
}