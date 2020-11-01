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
    $dateStart = (new DateTimeImmutable($faker->date()));

    return [
        "id" => Uuid::generate(),
        "title" => $faker->jobTitle,
        "date_start" => $dateStart->format('Y-m-d'),
        "date_end" => $dateStart->add(new DateInterval('P10D')),
        "status" => FestivalStatus::STATE_PUBLISHED_ID,
    ];
});
