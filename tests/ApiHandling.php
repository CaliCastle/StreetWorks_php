<?php

namespace Tests;

use StreetWorks\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestResponse;

trait ApiHandling
{
    /**
     * Should see success json response.
     *
     * @param TestResponse $response
     */
    public function shouldSeeSuccessResponse(TestResponse $response)
    {
        return $this->shouldSeeResponseInJson(true, $response);
    }

    /**
     * Should see error json response.
     *
     * @param TestResponse $response
     */
    public function shouldSeeFailureResponse(TestResponse $response)
    {
        return $this->shouldSeeResponseInJson(false, $response);
    }

    /**
     * Should see a json response.
     *
     * @param bool         $success
     * @param TestResponse $response
     */
    protected function shouldSeeResponseInJson($success, TestResponse $response)
    {
        $response->assertJson([
            'status' => $success ? 'success' : 'error'
        ]);

        return $this;
    }

    /**
     * Act as and get the user.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    protected function actAsUserUsingApi($attributes = [])
    {
        // Get user
        if (empty($attributes)) {
            $user = User::first();
        } else {
            $user = User::where($attributes)->first();
        }
        // Act as user
        Passport::actingAs($user, ['*']);

        return $user;
    }
}