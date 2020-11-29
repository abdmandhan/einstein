<?php

namespace Database\Seeders;

use App\Models\Discuss;
use App\Models\DiscussReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiscussSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::all(['id']);

        foreach ($user as $key => $value) {
            Discuss::factory(2)->create([
                'user_id'   => $value
            ])->each(function ($data) {
                DiscussReply::factory(2)->create([
                    'discuss_id'    => $data->id,
                ]);
            });
        }
    }
}
