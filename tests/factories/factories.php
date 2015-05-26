<?php

$factory('App\User' ,[
    'username' => $faker->unique()->userName,
    'email' => $faker->unique()->email,
    'password' => $faker->word,
    'profile_img' => $faker->sentence,
    'facebook' => $faker->sentence,
    'status' => 1,
]);

$factory('App\Comp' ,[
    'title' => $faker->sentence,
    'preview_type' => 's',
    'voting_type' => 'b',
    'preview_link' => $faker->url,
    'stem_link' => $faker->url,
    'subm_end_date' => $faker->date($format = 'Y-m-d', $max = '+3 year'),
    'comp_end_date' => $faker->date($format = 'Y-m-d', $max = '+3 year'),
    'header_img' => 'test',
    'song_title' => $faker->word,
    'genre' => $faker->word,
    'bpm' => $faker->word,
    'description' => $faker->sentence,
    'rules' => $faker->sentence,
    'prizes' => $faker->sentence,
    'url' => $faker->url,
    'facebook' => $faker->url,
    'twitter' => $faker->url,
    'user_id' => 'factory:App\User',
    'status' => 'v',

]);

$factory('App\Voting' ,[
    'show_date' => $faker->date($format = 'Y-m-d', $max = '+3 year'),
    'status' => 'v',
    'comp_id' => 'factory:App\Comp',
]);

$factory('App\Submition' ,[
    'title' => $faker->word,
    'link' => $faker->url,
    'status' => 'v',
    'user_id' => 'factory:App\User',
    'comp_id' => 'factory:App\Comp',
    'voting_id' => 'factory:App\Voting',
    'votes' => 0,
]);