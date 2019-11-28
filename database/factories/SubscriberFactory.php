<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Enums\SubscriberStatus;

$factory->define(App\Subscriber::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'status' => SubscriberStatus::getRandomValue(),
    ];
});
