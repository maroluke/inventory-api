<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => app('hash')->make('password'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $location = new Location;
            $location->branch = 'Academy';
            $location->room = '000';
            $location->description = 'Arbeitsplatz von ' . $user->name;
            $location->save();

            $user->location()->associate($location)->save();
        });
    }
}
