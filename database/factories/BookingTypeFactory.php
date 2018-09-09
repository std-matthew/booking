<?php

use Faker\Generator as Faker;

$factory->define(App\BookingType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->randomNumber(3),
    ];
});
