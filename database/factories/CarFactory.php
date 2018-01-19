<?php

use Faker\Generator as Faker;

$factory->define(StreetWorks\Models\Car::class, function (Faker $faker) {
    return [
        'name'         => $faker->words(3, true),
        'manufacturer' => collect(['Toyota', 'Volkswagen', 'Ford', 'Nissan', 'Chrysler', 'BMW'])->random(),
        'model'        => str_random('4'),
        'description'  => $faker->sentence,
        'year'         => $faker->year,
        'license'      => str_random(9)
    ];
});
