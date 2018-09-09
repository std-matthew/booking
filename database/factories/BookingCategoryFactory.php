<?php

use Faker\Generator as Faker;

$factory->define(App\BookingCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'limit' => $faker->randomNumber(2),
    ];
});
