<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{

    public function definition()
    {
        if ($this->faker->boolean(80)) {
            $v = rand(1, 7);
            $v_i = null;
        } else {
            $v = null;
            $v_i = rand(1, 7);
        }

        $title = $this->faker->sentence(4);

        return [
            'title' => $title,
            'short_title' => Str::slug($title),
            'volume' => $v,
            'volume_irregular' => $v_i,
            'edition' => $this->faker->boolean(20),
            'year' => rand(1500, 2000),
        ];
    }
}