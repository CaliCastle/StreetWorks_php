<?php

namespace StreetWorks\Http\Controllers\Api;

use Illuminate\Http\Request;
use StreetWorks\Models\Post;
use StreetWorks\Models\Comment;
use StreetWorks\Http\Requests\PostRequest;
use StreetWorks\Http\Controllers\Controller;
use StreetWorks\Http\Requests\CommentRequest;

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
        $post = $request->user()->posts()->create($request->all());

        return $this->successResponse(compact('post'));
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

    /**
     * @param Post    $post
     * @param Request $request
     *
     * @return array
     */
    public function comment(Post $post, CommentRequest $request)
    {
        $user = $request->user();

        $comment = $user->comments()->make([
            'text'    => $request->input('text'),
            'post_id' => $post->id
        ]);

        if ($request->has('image_id')) {
            $comment->image_id = $request->input('image_id');
        }

        $comment->save();

        return $this->successResponse();
    }
}