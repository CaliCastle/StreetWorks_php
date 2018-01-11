<?php

namespace Tests\Feature;

use Tests\ApiTestCase;
use StreetWorks\Models\Post;
use StreetWorks\Models\Image;
use StreetWorks\Models\Comment;
use Illuminate\Foundation\Testing\WithFaker;

class PostsApiTest extends ApiTestCase
{
    use WithFaker;

    /** @test */
    public function user_can_publish_a_new_post()
    {
        $user = $this->actAsUserUsingApi();
        // Create image
        $image = factory(Image::class)->create();
        // Call api
        $text = $this->faker->sentences(2, true);
        $response = $this->json('POST', route('posts'), [
            'text'     => $text,
            'image_id' => $image->id
        ]);
        // Check database
        $this->shouldSeeSuccessResponse($response)
            ->assertDatabaseHas(Post::table(), [
                'user_id' => $user->id,
                'text'    => $text
            ]);
    }

    /** @test */
    public function user_can_like_posts()
    {
        $this->actAsUserUsingApi();
        // Create a post
        $post = factory(Post::class)->create();
        // Call api
        $response = $this->json('PATCH', route('post', ['post' => $post->id]));
        // Check
        $this->shouldSeeSuccessResponse($response);
    }

    /** @test */
    public function user_can_comment_on_posts()
    {
        $user = $this->actAsUserUsingApi();
        // Create a post
        $post = factory(Post::class)->create();
        // Call api
        $text = $this->faker->sentences(2, true);
        $response = $this->json('POST', route('comment-post', ['post' => $post->id]), [
            'text' => $text,
        ]);
        // Check
        $this->shouldSeeSuccessResponse($response)->assertDatabaseHas(Comment::table(), [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'text' => $text
        ]);
    }
}
