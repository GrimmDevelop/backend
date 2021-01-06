<?php


namespace Database\Factories;


use Grimm\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt(Str::random(10)),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(60),
            'api_only' => true
        ];
    }
}