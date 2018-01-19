<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Models\Car;
use StreetWorks\Http\Requests\CarsRequest;
use StreetWorks\Http\Controllers\Controller;

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
     * Create a car.
     *
     * @param CarsRequest $request
     */
    public function create(CarsRequest $request)
    {
        try {
            $car = $request->user()->cars()->create($request->all());
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse(compact('car'));
    }

    /**
     * Update a car.
     *
     * @param CarsRequest $request
     * @param Car         $car
     *
     * @return array
     */
    public function update(CarsRequest $request, Car $car)
    {
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
}