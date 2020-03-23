<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Akomodasi::class, function (Faker $faker) {
    return [
        'kabkota_id' => factory(App\Models\Kabkota::class),
        'eselon_2' => $faker->randomNumber(),
        'eselon_3' => $faker->randomNumber(),
        'madya' => $faker->randomNumber(),
        'eselon_4_gol_3_4' => $faker->randomNumber(),
        'gol_1_2' => $faker->randomNumber(),
    ];
});
