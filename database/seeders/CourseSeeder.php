<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseTask;
use App\Models\CourseTaskAnswer;
use App\Models\CourseTaskQuestion;
use App\Models\CourseTeacher;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\User;
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

        $teacher = collect(User::role('teacher')->get());

        Course::factory(10)->create()->each(function ($course) use ($teacher) {
            CourseContent::factory(4)->create([
                'course_id' => $course->id,
                'name'      => $course->name,
            ]);

            $teachers = $teacher->random(3);

            foreach ($teachers as $key => $value) {
                CourseTeacher::create([
                    'course_id'     => $course->id,
                    'teacher_id'    => $value->id
                ]);
            }

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
