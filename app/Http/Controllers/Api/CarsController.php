<?php

namespace StreetWorks\Http\Controllers\Api;

use StreetWorks\Http\Requests\CarsRequest;
use StreetWorks\Http\Controllers\Controller;

class CarsController extends Controller
{
    /**
     * Create a car.
     *
     * @param CarsRequest $request
     */
    public function create(CarsRequest $request)
    {
        return $request->user()->cars()->create($request->all());
    }
}