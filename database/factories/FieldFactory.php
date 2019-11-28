<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use App\Enums\FieldType;

$factory->define(App\Field::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'type' => FieldType::getRandomValue(),
    ];
});
