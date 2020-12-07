<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Education;
use App\Models\Golongan;
use App\Models\Grade;
use App\Models\Position;
use App\Models\TransactionStatus;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\UserTeacher;
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

        //position teacher
        $position_teacher = [
            ['name'  => 'Ketua'],
            ['name'  => 'Wakil'],
            ['name'  => 'Sekretaris'],
            ['name'  => 'Bendahara'],
        ];
        Position::insert($position_teacher);

        //education teacher
        $education_teacher = [
            ['name' => 'SD'],
            ['name' => 'SMP'],
            ['name' => 'SMA'],
            ['name' => 'D1'],
            ['name' => 'D2'],
            ['name' => 'D3'],
            ['name' => 'D4'],
            ['name' => 'S1'],
            ['name' => 'S2'],
            ['name' => 'S3'],
        ];
        Education::insert($education_teacher);

        //golongan teacher
        $golongan_teacher = [
            ['name' => 'I'],
            ['name' => 'II'],
            ['name' => 'III'],
        ];
        Golongan::insert($golongan_teacher);

        $user = User::create([
            'name'      => 'Abdurrahman Ramadhan',
            'email'     => 'abdmandhan@gmail.com',
            'photo'     => 'storage/user/2.jpg',
            'phone'     => '012312123123',
            'address'   => 'asdfasdfasdf',
            'password'  => '12341234'
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name'      => 'Teacher 1',
            'email'     => 'teacher@example.com',
            'phone'     => '012312123123',
            'photo'     => 'storage/user/2.jpg',
            'address'   => 'asdfasdfasdf',
            'password'  => '12341234'
        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name'      => 'Student1',
            'email'     => 'student@example.com',
            'photo'     => 'storage/user/2.jpg',
            'phone'     => '012312123123',
            'address'   => 'asdfasdfasdf',
            'password'  => '12341234'
        ]);
        $user->assignRole('student');
        UserStudent::create([
            'user_id'   => $user->id,
            'grade_id'  => random_int(1, 3)
        ]);


        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('student');
            UserStudent::create([
                'user_id'   => $user->id,
                'grade_id'  => random_int(1, 3)
            ]);
        });

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('teacher');
            UserTeacher::create([
                'user_id'       => $user->id,
                'position_id'   => Position::all()->random()->id,
                'education_id'  => Education::all()->random()->id,
                'golongan_id'   => Golongan::all()->random()->id,
            ]);
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

        //transaction status
        $transaction_status = [
            ['name'  => 'PENDING', 'color' => 'warning'],
            ['name'  => 'FINISH', 'color' => 'success'],
            ['name'  => 'REJECT', 'color' => 'error'],
        ];

        TransactionStatus::insert($transaction_status);

        //discuss
        $this->call([
            DiscussSeeder::class
        ]);

        //announcement
        Announcement::factory(10)->create();
    }
}
