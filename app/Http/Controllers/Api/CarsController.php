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
            $request->user()->cars()->create($request->all());

            return $this->successResponse();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->errorResponse();
        }
    }
}