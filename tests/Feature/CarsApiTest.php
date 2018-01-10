<?php

namespace Tests\Feature;

use Tests\ApiTestCase;
use StreetWorks\Models\Car;

class CarsApiTest extends ApiTestCase
{
    /** @test */
    public function user_can_add_a_car()
    {
        $this->actAsUserUsingApi();
        // Call api
        $car = factory(Car::class)->make();
        $response = $this->json('POST', route('car'), $car->toArray());
        // Check database
        $this->shouldSeeSuccessResponse($response);
        $this->assertDatabaseHas(Car::table(), $car->toArray());
    }
}
