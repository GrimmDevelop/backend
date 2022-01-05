<?php

namespace Database\Factories;

use Carbon\Carbon;
use Grimm\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $birthDate = Carbon::now()->subYears($this->faker->randomNumber(3));

        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'birth_date' => $birthDate->format('Y'),
            'death_date' => $birthDate->addYears($this->faker->randomNumber(2))->format('Y'),
            'is_organization' => $this->faker->boolean(20),
        ];
    }
}
