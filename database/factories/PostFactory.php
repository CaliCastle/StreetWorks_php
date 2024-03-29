<?php

use StreetWorks\Models\User;
use StreetWorks\Models\Car;
use Faker\Generator as Faker;
use StreetWorks\Models\Image;

$factory->define(StreetWorks\Models\Post::class, function (Faker $faker) {
    return [
        'text'     => $faker->sentences(3, true),
        'user_id'  => User::inRandomOrder()->first()->id,
        'image_id' => Image::inRandomOrder()->first()->id,
        'car_id'   => Car::inRandomOrder()->first()->id
    ];
});
