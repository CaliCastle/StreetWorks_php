<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Models\Car;
use Illuminate\Http\Request;
use StreetWorks\Models\CarMod;
use StreetWorks\Http\Requests\CarsRequest;
use StreetWorks\Http\Controllers\Controller;
use StreetWorks\Http\Requests\CarModRequest;

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
     * Get all cars of a user.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request)
    {
        $cars = $request->user()->cars()->primaryFirst()->latest()->get();

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
    public function updateMod(Car $car, CarMod $mod, CarModRequest $request)
    {
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
    public function deleteMod(Car $car, CarMod $mod)
    {
        try {
            $mod->delete();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse();
    }
}