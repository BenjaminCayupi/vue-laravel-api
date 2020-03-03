<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Arriendo;
use Faker\Generator as Faker;

$factory->define(Arriendo::class, function (Faker $faker) {
    return [
        'producto_id' => $faker->randomDigitNot(0),
        'cliente_id' => $faker->randomDigitNot(0) ,
        'fentrega' => $faker->dateTime,
        'ftermino' => $faker->dateTime,
        'cantidad' => $faker->randomDigitNot(0),
        'estado' => $faker->word,
    ];
});
