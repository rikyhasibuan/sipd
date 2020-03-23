<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'nip' => $faker->word,
        'password' => bcrypt($faker->password),
        'level_id' => $faker->randomNumber(),
    ];
});
