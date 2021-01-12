<?php

namespace Database\Factories;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
use Webpatser\Uuid\Uuid;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        return [
            'id' => Uuid::generate(),
            'name' => $this->faker->name,
            'email' => 'admin@admin.ru',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => Str::random(10),
        ];
    }
}
