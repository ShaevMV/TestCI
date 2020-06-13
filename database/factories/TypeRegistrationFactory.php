<?php

use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(TypeRegistrationModule::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
    ];
});
