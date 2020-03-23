<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Belanja::class, function (Faker $faker) {
    return [
        'program_id' => factory(App\Models\Program::class),
        'kegiatan_id' => factory(App\Models\Kegiatan::class),
        'kode_belanja' => $faker->word,
        'nama_belanja' => $faker->word,
    ];
});
