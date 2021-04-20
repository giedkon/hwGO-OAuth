<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Server::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
           'name' => $this->faker->name,
           'server_ip' => $this->faker->ipv4,
           'server_port' => $this->faker->numberBetween(0, 65535),
           'password' => 'password', // password
       ];
    }
}
