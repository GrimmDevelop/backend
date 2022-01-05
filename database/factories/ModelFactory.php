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

use Illuminate\Support\Str;

$factory->define(Grimm\PersonCode::class, function (Faker\Generator $faker) {

    return [
        'error_generated' => $faker->boolean(20),
        'internal' => $faker->boolean(20),
        'name' => Str::slug($faker->sentence(3)),
    ];
});

$factory->define(Grimm\PersonInformation::class, function (Faker\Generator $faker) {
    /** @var \Grimm\PersonCode $code */
    $code = Grimm\PersonCode::query()->orderByRaw('RAND()')->first();

    /** @var \Grimm\Person $person */
    $person = Grimm\Person::query()->orderByRaw('RAND()')->first();

    if (!$code || !$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_code_id' => $code->id,
        'person_id' => $person->id,
        'data' => $faker->paragraph,
    ];
});

$factory->define(Grimm\PersonPrint::class, function (Faker\Generator $faker) {
    /** @var \Grimm\Person $person */
    $person = Grimm\Person::query()->orderByRaw('RAND()')->first();

    if (!$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_id' => $person->id,
        'entry' => $faker->paragraph,
        'year' => rand(12000, 20000) / 10
    ];
});

$factory->define(Grimm\PersonInheritance::class, function (Faker\Generator $faker) {
    /** @var \Grimm\Person $person */
    $person = Grimm\Person::query()->orderByRaw('RAND()')->first();

    if (!$person) {
        throw new \Exception('no book or person found for association');
    }

    return [
        'person_id' => $person->id,
        'entry' => $faker->paragraph,
    ];
});

$factory->define(Grimm\BookPersonAssociation::class, function (Faker\Generator $faker) {
    /** @var \Grimm\Book $book */
    $book = Grimm\Book::query()->orderByRaw('RAND()')->first();

    /** @var \Grimm\Person $person */
    $person = Grimm\Person::query()->orderByRaw('RAND()')->first();

    if (!$book || !$person) {
        throw new \Exception('no book or person found for association');
    }

    $page = rand(1, 999);
    $page_to = rand($page, $page + 25);

    return [
        'book_id' => $book->id,
        'person_id' => $person->id,
        'page' => $page,
        'page_to' => $page_to,
        'page_description' => $faker->paragraph,
        'line' => rand(1, 50),
    ];
});
