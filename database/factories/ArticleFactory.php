<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Article::class, function (Faker $faker) {
    return [
        'cid' => mt_rand(2,5),
        'title' => $faker->sentence(),
        'author' => $faker->name(),
        'desn' => $faker->sentence(),
        'pic' => $faker->imageUrl(),
        'body' => $faker->text()
    ];
});
