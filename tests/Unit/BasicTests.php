<?php

namespace Tests\Unit;

use Tests\TestCase;
use StreetWorks\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTests extends TestCase
{
    public function createsAUser()
    {
        $attributes = [
            'first_name' => 'Cali',
            'last_name' => 'Castle',
            'username' => 'calicastle',
            'email' => 'calic@8ninths.com',
            'password' => bcrypt('password')
        ];

        $user = User::create($attributes);

        $this->assertTrue($user->first_name == "Cali");
    }
}
