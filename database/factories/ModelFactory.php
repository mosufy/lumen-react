<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// Seed web users
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'email'    => $faker->safeEmail,
        'name'     => $faker->userName,
        'password' => (new \Illuminate\Hashing\BcryptHasher())->make('password'),
        'uid'      => Faker\Provider\Uuid::uuid()
    ];
});

// Seed oauth client
$factory->define(\App\Models\OAuthClient::class, function (Faker\Generator $faker) {
    return [
        'id'     => str_replace('-', '', $faker->uuid),
        'secret' => str_replace('-', '', $faker->uuid),
        'name'   => $faker->domainName
    ];
});

// Seed oauth scope
$factory->define(\App\Models\OAuthScope::class, function (Faker\Generator $faker) {
    return [
        'id'          => $faker->safeColorName,
        'description' => $faker->sentences()
    ];
});
