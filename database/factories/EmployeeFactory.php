<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$offices = App\Office::pluck('office_name')->all();

$factory->define(Employee::class, function (Faker $faker) use ($offices) {
    return [
        "desk" => $faker->unique()->randomDigitNotNull,
        "name" => $faker->name,
        "univ" => $faker->university,
        "shift" => $faker->randomElement(['07.00 - 10.00','13.00 - 17.00']),
        "office" => $faker->randomElement($offices),
        "status" => $faker->randomElement(['aktif', 'non-aktif']),
        "start" => now(),
        "end" => $faker->dateTimeBetween('+1 week', '+3 month'),
    ];
});
