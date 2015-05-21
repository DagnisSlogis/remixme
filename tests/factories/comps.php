<?php

$factory('App\Comp' ,[

    'title' => $faker->word,
    'preview_link' => $faker->url,
    'stem_link' => $faker->url,
    'subm_end_date' => $faker->date,
    'comp_end_date' => $faker->date,
    'song_title' => $faker->word,
    'genre' => $faker->word,
    'bmp' => $faker->word,
    'description' => $faker->sentence,
    'rules' => $faker->sentence,
    'prizes' => $faker->sentence,
    'url' => $faker->url,
    'facebook' => $faker->url,
    'twitter' => $faker->url,
    'user_id' => 'factory:App\User'

]);