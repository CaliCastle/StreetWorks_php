<?php

namespace StreetWorks\Http\Controllers\Api;

use Illuminate\Http\Request;
use StreetWorks\Models\Post;
use StreetWorks\Http\Requests\PostRequest;
use StreetWorks\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Create a post.
     *
     * @param PostRequest $request
     *
     * @return array
     */
    public function create(PostRequest $request)
    {
        // Create post
        $request->user()->posts()->create($request->all());

        return $this->successResponse();
    }

    /**
     * Like/unlike a post.
     *
     * @param Post $post
     *
     * @return array
     */
    public function likeOrUnlike(Post $post, Request $request)
    {
        $user = $request->user();

        $user->likeOrUnlike($post);

        return $this->successResponse();
    }
}