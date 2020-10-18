<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'email'     => 'teacher@gmail.com',
            'password'  => '12341234'
        ]);
        $user->assignRole('teacher');

        $user = User::create([
            'name'      => 'Student1',
            'email'     => 'student@gmail.com',
            'password'  => '12341234'
        ]);
        $user->assignRole('student');

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('student');
        });
    }
}
