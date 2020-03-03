<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        'marca' => $faker->word,
        'modelo' => $faker->word,
        'categoria' => $faker->word,
        'nserie' => $faker->word
    ];
});
