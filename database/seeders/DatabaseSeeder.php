<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\TransactionStatus;
use App\Models\User;
use App\Models\UserStudent;
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
            'phone'     => '012312123123',
            'photo'     => 'storage/user/2.jpg',
            'password'  => '12341234'
        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name'      => 'Student1',
            'email'     => 'student@example.com',
            'photo'     => 'storage/user/2.jpg',
            'phone'     => '012312123123',
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
    }
}
