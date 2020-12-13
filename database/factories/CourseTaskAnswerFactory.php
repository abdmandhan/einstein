<?php

namespace Database\Factories;

use App\Models\CourseTaskAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTaskAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseTaskAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        de($this->count);
        return [
            'answer'    => $this->faker->paragraph(),
            'is_true'   => $this->faker->numberBetween(0, 1)
        ];
    }
}
