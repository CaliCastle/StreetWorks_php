<?php

use Faker\Generator as Faker;

$factory->define(StreetWorks\Models\Image::class, function (Faker $faker) {
    return [
        'title'       => $faker->words(4, true),
        'description' => $faker->sentences(3, true),
        'location'    => $faker->word
    ];
});
