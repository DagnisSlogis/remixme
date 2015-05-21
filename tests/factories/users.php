<?php

$factory('App\User' ,[

    'username' => $faker->username,
    'email' => $faker->email,
    'password' => $faker->word,
    'profile_img' => $faker->sentence,
    'facebook' => $faker->sentence,
    'status' => 1,
    ]);