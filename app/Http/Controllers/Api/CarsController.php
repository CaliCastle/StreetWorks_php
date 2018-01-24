<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Models\Car;
use Illuminate\Http\Request;
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
     * Get all cars of a user.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAll(Request $request)
    {
        $cars = $request->user()->cars;

        return $this->successResponse(compact('cars'));
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
     * @param Request $request
     * @param Car         $car
     *
     * @return array
     */
    public function update(Request $request, Car $car)
    {
        $this->validate($request, [
            'name'         => 'max:255',
            'manufacturer' => 'max:255',
            'model'        => 'max:20',
            'year'         => 'size:4',
            'primary'      => 'boolean',
            'license'      => 'max:18',
            'image_id'     => 'exists:images,id'
        ]);

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