<?php

namespace Database\Factories;

use App\Models\CourseTaskQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTaskQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseTaskQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'question'          => $this->faker->paragraph(),
            // 'question_type_id'  =>1
        ];
    }
}
