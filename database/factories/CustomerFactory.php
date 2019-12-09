<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Customer;
use Illuminate\Support\Str;

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

$factory->define(Customer::class, function () {
    $faker = Faker\Factory::create('bn_BD');
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'mobile' => $faker->phoneNumber,
        'nid' =>  $faker->ean8,
        'passport_id' =>  $faker->swiftBicNumber,
        'account_id'=> $faker->bankAccountNumber,
        'user_id'=> App\User::all()->random()->id,
    ];
});
