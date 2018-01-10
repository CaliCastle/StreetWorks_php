<?php

use Faker\Generator as Faker;

$factory->define(StreetWorks\Models\Car::class, function (Faker $faker) {
    return [
        'title'       => $faker->words(3, true),
        'make'        => collect(['Toyota', 'Volkswagen', 'Ford', 'Nissan', 'Chrysler', 'BMW'])->random(),
        'model'       => str_random('4'),
        'description' => $faker->sentence,
        'model_year'  => $faker->year,
        'license'     => str_random(9)
    ];
});
