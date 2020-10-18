<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseTask;
use App\Models\CourseTaskAnswer;
use App\Models\CourseTaskQuestion;
use App\Models\CourseType;
use App\Models\Difficulty;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        CourseType::insert([
            ['name' => 'Matematika'],
            ['name' => 'Fisika'],
            ['name' => 'Biologi'],
        ]);

        Difficulty::insert([
            ['name' => 'Easy'],
            ['name' => 'Medium'],
            ['name' => 'Hard'],
        ]);

        Course::factory(10)->create()->each(function ($course) {
            CourseContent::factory(4)->create([
                'course_id' => $course->id,
                'name'      => $course->name,
            ]);


            CourseTask::factory(1)->create([
                'course_id' => $course->id
            ])->each(function ($courseTask) {
                CourseTaskQuestion::factory(1)->create([
                    'course_task_id'    => $courseTask->id
                ])->each(function ($courseTaskQuestion) {
                    CourseTaskAnswer::factory(1)->create([
                        'course_task_question_id'   => $courseTaskQuestion->id
                    ]);
                });;
            });
        });
    }
}
