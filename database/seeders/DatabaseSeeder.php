<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class
        ]);

        $user = User::create([
            'name'      => 'Abdurrahman Ramadhan',
            'email'     => 'abdmandhan@gmail.com',
            'password'  => '12341234'
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name'      => 'Teacher 1',
            'email'     => 'teacher@example.com',
            'password'  => '12341234'
        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name'      => 'Student1',
            'email'     => 'student@example.com',
            'password'  => '12341234'
        ]);
        $user->assignRole('student');

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('student');
        });

        //grades
        $data = [
            ['name' => 'VII'],
            ['name' => 'VIII'],
            ['name' => 'IX'],
        ];

        Grade::insert($data);

        //course
        $this->call([
            CourseSeeder::class
        ]);
    }
}
