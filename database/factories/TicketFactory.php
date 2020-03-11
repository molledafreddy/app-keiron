<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ticket;
use App\User;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'ticket_pedido' => $faker->randomElement(['free', 'requested', 'assigned'])
    ];
});
