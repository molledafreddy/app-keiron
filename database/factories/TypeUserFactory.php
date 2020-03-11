x`<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TypeUser;
use Faker\Generator as Faker;

$factory->define(TypeUser::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['USER_ADMIN', 'USER_REGULAR']),
    ];
});
