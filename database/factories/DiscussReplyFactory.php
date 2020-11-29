<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\DiscussReply;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscussReply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id'   => User::all()->random()->id,
            'text'      => $this->faker->paragraph()
        ];
    }
}
