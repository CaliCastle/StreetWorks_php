<?php

use Faker\Generator as Faker;

$factory->define(StreetWorks\Models\User::class, function (Faker $faker) {
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'username'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});
