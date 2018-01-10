<?php

namespace StreetWorks\Http\Controllers\Api;

use Illuminate\Http\Request;
use StreetWorks\Http\Controllers\Controller;

class ProfileController extends Controller
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