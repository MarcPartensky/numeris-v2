<?php

use App\Models\Address;
use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'address_id' => factory(Address::class),
        'name'      => $faker->company,
        'reference' => (string) $faker->numberBetween(00, 99) . '-' . (string) $faker->numberBetween(0000, 9999)
    ];
});
