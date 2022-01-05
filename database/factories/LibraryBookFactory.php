<?php

namespace Database\Factories;

use Grimm\LibraryBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryBookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LibraryBook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $catalog_id = $this->faker->numberBetween(1, 10000);

        if ($this->faker->boolean(20)) {
            $catalog_id .= $this->faker->randomLetter();
        }

        return [
            'catalog_id' => $catalog_id,
            'title' => $this->faker->sentence,
        ];
    }
}
