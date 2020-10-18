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
        User::create([
            'name'      => 'Abdurrahman Ramadhan',
            'email'     => 'abdmandhan@gmail.com',
            'password'  => '12341234'
        ]);

        User::factory(10)->create();
    }
}
