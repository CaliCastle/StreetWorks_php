<?php

use StreetWorks\Models\User;
use Faker\Generator as Faker;
use StreetWorks\Models\Image;

$factory->define(StreetWorks\Models\Post::class, function (Faker $faker) {
    return [
        'text'     => $faker->sentences(3, true),
        'user_id'  => User::first()->id,
        'image_id' => Image::inRandomOrder()->first()->id
    ];
});
