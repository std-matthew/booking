<?php

use Faker\Generator as Faker;

$factory->define(App\BookingLocation::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'description' => $faker->sentence,
    ];
});
