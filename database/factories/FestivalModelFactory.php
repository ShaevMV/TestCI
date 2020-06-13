<?php

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Webpatser\Uuid\Uuid;

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

/** @var Factory $factory */

$factory->define(FestivalModel::class, function (Faker $faker) {
    return [
        "id" => Uuid::generate(),
        "title" => $faker->jobTitle,
        "date_start" => (new DateTimeImmutable($faker->date()))->format('Y-m-d'),
        "date_end" => (new DateTimeImmutable($faker->date()))->format('Y-m-d'),
        "status" => FestivalStatus::STATE_PUBLISHED_ID,
    ];
});
