<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'sku' => $faker->randomNumber(9),
        'title' => $faker->word,
        'price' => $faker->randomFloat(3, 0, 15),
        'description'   => $faker->paragraph,
        'color' => $faker->randomElement(array('RED', 'GREEN', 'YELLOW', 'BLUE', 'PURPLE')),
        'stock'  => $faker->randomDigit()
    ];
});
