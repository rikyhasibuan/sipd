<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Program::class, function (Faker $faker) {
    return [
        'kode_program' => $faker->word,
        'bendahara' => $faker->word,
        'nama_program' => $faker->word,
    ];
});
