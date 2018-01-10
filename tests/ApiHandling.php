<?php

namespace Tests;

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
        $this->shouldSeeResponseInJson(true, $response);
    }

    /**
     * Should see error json response.
     *
     * @param TestResponse $response
     */
    public function shouldSeeFailureResponse(TestResponse $response)
    {
        $this->shouldSeeResponseInJson(false, $response);
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
    }
}