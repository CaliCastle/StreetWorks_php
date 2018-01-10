<?php

namespace Tests\Unit;

use Tests\ApiTestCase;
use StreetWorks\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersApiTest extends ApiTestCase
{
    /** @test */
    public function user_can_add_a_car()
    {
        // Get user
        $user = User::first();
        // Act as user
        Passport::actingAs($user, ['*']);
        // Call api

    }
}
