<?php

namespace Tests\Unit;

use Tests\ApiTestCase;
use StreetWorks\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationApiTest extends ApiTestCase
{
    use RefreshDatabase, WithFaker;

    /** test */
    public function a_user_can_register()
    {
        // Mock attributes
        $attributes = [
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'username'   => $this->faker->userName,
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => 'secret'
        ];
        // Make api call
        $response = $this->post(route('sign-up'), $attributes);
        // See success response status
        $this->shouldSeeSuccessResponse($response);
    }

    /** test */
    /* IMPORTANT: This test will reset oauth secret and id */
    public function a_user_can_login()
    {
        // Create a user
        $user = factory(User::class)->create();
        // Acting as the user
        Passport::actingAs($user, ['*']);
        // Get profile
        $response = $this->get(route('profile'));

        $response->assertStatus(200);
        $response->assertJson($user->toArray());
    }
}
