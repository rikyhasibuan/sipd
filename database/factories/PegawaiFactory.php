<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Pegawai::class, function (Faker $faker) {
    return [
        'nip' => $faker->word,
        'nama' => $faker->word,
        'golongan' => $faker->word,
        'pangkat' => $faker->word,
        'jabatan' => $faker->word,
        'eselon' => $faker->word,
    ];
});
