<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Harian::class, function (Faker $faker) {
    return [
        'kabkota_id' => factory(App\Models\Kabkota::class),
        'gol_1' => $faker->randomNumber(),
        'gol_2' => $faker->randomNumber(),
        'gol_3' => $faker->randomNumber(),
        'gol_4' => $faker->randomNumber(),
    ];
});
