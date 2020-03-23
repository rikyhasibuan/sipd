<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Kegiatan::class, function (Faker $faker) {
    return [
        'program_id' => factory(App\Models\Program::class),
        'kode_kegiatan' => $faker->word,
        'nama_kegiatan' => $faker->word,
    ];
});
