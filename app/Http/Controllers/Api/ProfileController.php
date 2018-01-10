<?php

namespace StreetWorks\Http\Controllers\Api;

use Illuminate\Http\Request;

class ProfileController
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return $request->user();
    }
}