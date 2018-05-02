<?php

namespace StreetWorks\Http\Controllers\Api;

use Illuminate\Http\Request;
use StreetWorks\Models\Post;
use StreetWorks\Http\Controllers\Controller;

class FeedController extends Controller
{
    private $request;

    /**
     * FeedController constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Fetch posts.
     *
     * @return array
     */
    public function index()
    {
        // TODO: Dynamic data
//        $user = $this->request->user();
        $posts = Post::latest()->paginate();

        return $this->successResponse(compact('posts'));
    }
}
