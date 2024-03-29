<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Models\Car;
use Illuminate\Http\Request;
use StreetWorks\Models\CarMod;
use Illuminate\Http\UploadedFile;
use StreetWorks\Http\Requests\CarsRequest;
use StreetWorks\Http\Controllers\Controller;
use StreetWorks\Http\Requests\CarModRequest;
use StreetWorks\Models\User;

class CarsController extends Controller
{
    /**
     * Show a car's profile/info.
     *
     * @param Car $car
     *
     * @return array
     */
    public function index(Car $car)
    {
        return $this->successResponse(compact('car'));
    }

    /**
     * Get all cars of current user.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request)
    {
        $user = $request->user();

        return $this->getAllForUser($user);
    }

    /**
     * Get all cars of the specific user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getAllForUser(User $user)
    {
        $cars = $user->cars()->primaryFirst()->latest()->get();

        return $this->successResponse(compact('cars'));
    }

    /**
     * Create a car.
     *
     * @param CarsRequest $request
     *
     * @return array
     */
    public function create(CarsRequest $request)
    {
        try {
            $car = $request->user()->cars()->create($request->all());
            $specs = $request->input('specs');

            if (! empty($specs) && is_array($specs)) {
                $car->specs = $specs;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse(compact('car'));
    }

    /**
     * Update a car.
     *
     * @param CarsRequest $request
     * @param Car     $car
     *
     * @return array
     */
    public function update(CarsRequest $request, Car $car)
    {
        // User should at least have one primary car
        $isPrimary = boolval($request->input('primary'));
        $hasPrimary = $request->user()->cars()->where([['primary', true], ['id', '!=', $request->input('id')]])->exists();

        // Input primary is false and user doesn't have a primary car, set it to primary
        if (! $isPrimary && ! $hasPrimary) {
            $request->replace(['primary' => true]);
        } elseif ($isPrimary && $hasPrimary) {
            $request->user()->cars()->where('primary', true)->update(['primary' => false]);
        }

        $car->update($request->all());

        return $this->successResponse(compact('car'));
    }

    /**
     * Upload cover image for car.
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return array
     */
    public function uploadCover(Request $request, Car $car)
    {
        if ($car->user->id != $request->user()->id) {
            throw new \Exception("Car doesn't belong to user");
        }

        $this->validate($request, [
            'image' => 'required|image'
        ]);

        $file = $request->file('image');

        if ($file instanceof UploadedFile) {
            $image = $request->user()->storeImage($file, [
                'title'       => '',
                'description' => 'Car Cover Photo'
            ]);
            $car->cover_image_id = $image->id;
            $car->save();

            return $this->successResponse(compact('image'));
        }

        return $this->errorResponse();
    }

    /**
     * Upload photo for a car.
     *
     * @param Request $request
     * @param Car     $car
     *
     * @return array
     */
    public function uploadPhoto(Request $request, Car $car)
    {
        if ($car->user->id != $request->user()->id) {
            throw new \Exception("Car doesn't belong to user");
        }

        $this->validate($request, [
            'image' => 'required|image'
        ]);

        $file = $request->file('image');

        if ($file instanceof UploadedFile) {
            $image = $request->user()->storeImage($file, [
                'title'       => '',
                'description' => 'Car Photo'
            ]);
            $car->image_id = $image->id;
            $car->save();

            return $this->successResponse(compact('image'));
        }

        return $this->errorResponse();
    }

    /**
     * Delete a car.
     *
     * @param Car $car
     *
     * @return array
     */
    public function delete(Car $car)
    {
        try {
            $car->delete();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }

    /**
     * Create a car mod.
     *
     * @param CarModRequest $request
     *
     * @return array
     */
    public function createMod(CarModRequest $request, Car $car)
    {
        $mod = $car->mods()->create($request->all());

        return $this->successResponse(compact('mod'));
    }

    /**
     * Get car mod.
     *
     * @param CarMod $mod
     *
     * @return CarMod
     */
    public function getMod(Car $car, CarMod $mod)
    {
        if ($mod->car_id !== $car->id) {
            return $this->errorResponse('Mod does not belong to this car!');
        }

        return $this->successResponse(compact('mod'));
    }

    /**
     * Get all mods.
     *
     * @param Car $car
     *
     * @return array
     */
    public function getAllMods(Car $car)
    {
        $mods = $car->mods()->latest()->get();

        return $this->successResponse(compact('mods'));
    }

    /**
     * Update mod.
     *
     * @param CarMod        $mod
     * @param CarModRequest $request
     *
     * @return array
     */
    public function updateMod(CarMod $mod, CarModRequest $request)
    {
        if ($request->user()->id !== $mod->car->user->id) {
            return $this->errorResponse('Not yours to edit!');
        }

        $mod->update($request->all());

        return $this->successResponse(compact('mod'));
    }

    /**
     * Delete mod.
     *
     * @param CarMod $mod
     *
     * @return array
     */
    public function deleteMod(Request $request, CarMod $mod)
    {
        if ($request->user()->id !== $mod->car->user->id) {
            return $this->errorResponse('Not yours to delete');
        }

        try {
            $mod->delete();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }

    /**
     * Get car's photos.
     *
     * @param Car $car
     *
     * @return array
     */
    public function getCarPhotos(Car $car)
    {
        $photos = $car->photos();

        return $this->successResponse(compact('photos'));
    }
}