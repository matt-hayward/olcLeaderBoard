<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Participant;
use App\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
        'participant_id' => function () {
            return factory(Participant::class)->create();
        },
        'type' => $faker->randomElement([Vote::FAIL, Vote::WIN]),
    ];
});
