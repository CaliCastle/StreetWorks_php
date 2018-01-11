<?php

namespace Tests\Feature;

use Tests\ApiTestCase;
use StreetWorks\Models\Image;
use StreetWorks\Models\Avatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;

class UsersApiTest extends ApiTestCase
{
    use WithFaker;

    /** @test */
    public function user_can_upload_an_avatar()
    {
        $user = $this->actAsUserUsingApi();

        // Call api
        $response = $this->json('POST', route('upload-avatar'), [
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        // Assert the file was stored...
        $this->shouldSeeSuccessResponse($response);
        $this->assertDatabaseHas(Avatar::table(), [
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->actAsUserUsingApi(['username' => 'calicastle']);

        // Call api
        $response = $this->json('POST', route('update-profile'), [
            'first_name' => 'First',
            'last_name'  => 'Last',
            'email'      => 'admin@domain.com'
        ]);

        $this->shouldSeeSuccessResponse($response);
    }

    /** @test */
    public function user_can_change_password()
    {
        $user = $this->actAsUserUsingApi();
        // Configure new password
        $newPassword = 'new_password';

        // Call api
        $response = $this->json('POST', route('password'), [
            'password' => $newPassword
        ]);
        // Assert
        $this->shouldSeeSuccessResponse($response)
            ->assertCredentials([
                'email'    => $user->email,
                'password' => $newPassword
            ], 'web');
    }

    /** @test */
    public function user_can_upload_photos()
    {
        $this->actAsUserUsingApi();

        // Call api
        $title = $this->faker->words(5, true);
        $response = $this->json('POST', route('upload-photo'), [
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'title' => $title
        ]);

        // Assert the file was stored...
        $this->shouldSeeSuccessResponse($response)->assertDatabaseHas(Image::table(), [
            'title' => $title
        ]);
    }

    /** @test */
    public function user_can_add_business_info()
    {
        $this->actAsUserUsingApi();

        // Call api
        $response = $this->json('POST', route('business'), [
            'description' => $this->faker->sentences(3, true),
            'address_1'   => $this->faker->streetAddress,
            'address_2'   => $this->faker->address,
            'city'        => 'Seattle',
            'state'       => 'WA',
            'country'     => 'USA',
            'phone'       => '2064565294',
            'email'       => 'info@8ninths.com'
        ]);
        // Assert success
        $this->shouldSeeSuccessResponse($response);
    }

    /** @test */
    public function user_can_view_business_info()
    {
        $user = $this->actAsUserUsingApi();

        // Call api
        $response = $this->json('GET', route('business-info', ['user' => $user->id]));
        // Assert success
        $this->shouldSeeSuccessResponse($response);
    }

    /** @test */
    public function user_can_update_business_info()
    {
        $this->actAsUserUsingApi();

        // Call api
        $response = $this->json('PATCH', route('business'), [
            'address_1'   => $this->faker->streetAddress,
            'address_2'   => $this->faker->address,
            'city'        => 'Seattle',
            'state'       => 'WA',
            'country'     => 'USA',
            'phone'       => '2064565294',
            'email'       => 'info@8ninths.com'
        ]);
        // Assert success
        $this->shouldSeeSuccessResponse($response);
    }
}
