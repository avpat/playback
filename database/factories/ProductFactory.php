<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku' => $faker->randomNumber(9),
        'title' => $faker->word,
        'description'   => $faker->paragraph,
        'color' => $faker->randomElement(array('RED', 'GREEN', 'YELLOW', 'BLUE', 'PURPLE')),
        'stock'  => $faker->randomDigit()
    ];
});
