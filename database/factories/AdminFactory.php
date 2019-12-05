<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Admin::class, function (Faker $faker) {
    return [
        //填充到数据库中的格式
        'username' => $faker->userName,
        'truename' => $faker->name,
        'password' => 'admin',
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'sex' => ['先生','女士'][rand(0,1)],
        'last_ip' => '127.0.0.1'
    ];
});
