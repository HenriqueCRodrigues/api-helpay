<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Product;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'amount' => $faker->randomFloat(2, 1, 100), 
        'qty_stock' => $faker->numberBetween(1, 100),
    ];
});


$factory->define(Order::class, function (Faker $faker) {
    $product = Product::all()->random();
    $element = [
        ['Visa' => '4539524042353483'], 
        ['Visa' => '4916224859446149'], 
        ['MasterCard' => '5379186394866767'], 
        ['Visa' => '4916062183400303'], 
        ['MasterCard' => '5545749725395852'], 
        ['Visa' => '4929326656825576']
    ];

    $element = $faker->randomElement($element);
    $flag = key($element);

    return [
        'product_id' => $product->id,
        'quantity_purchased' => $product->qty_stock,
        'card' => [
            [
                'owner' => $faker->name,
                'card_number' => $element[$flag], 
                'date_expiration' => $faker->creditCardExpirationDate->format('m/Y'), 
                'flag' => $flag, 
                'cvv' => $faker->numberBetween(100, 999)
            ]
        ]
    ];
});
