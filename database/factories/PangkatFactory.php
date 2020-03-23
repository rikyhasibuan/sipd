<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Pangkat::class, function (Faker $faker) {
    return [
        'nama_pangkat' => $faker->word,
    ];
});
