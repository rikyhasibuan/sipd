<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Jabatan::class, function (Faker $faker) {
    return [
        'nama_jabatan' => $faker->word,
    ];
});
