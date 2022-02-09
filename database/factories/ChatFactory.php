<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    protected $model = Chat::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'filename' => $this->faker->sentence.'.txt',
            'friendly_name' => $this->faker->sentence,
        ];
    }
}
