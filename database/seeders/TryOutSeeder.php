<?php

namespace Database\Seeders;

use App\Models\Difficulty;
use App\Models\TryOut;
use App\Models\TryOutQuestion;
use App\Models\TryOutAnswer;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TryOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create();

        $data_try_out = [
            [
                'name'              => 'TRY OUT NASIONAL 1',
                'difficulty_id'     => Difficulty::all()->random()->id,
                'date_start'        => $faker->dateTime(),
                'date_finish'       => $faker->dateTime(),
                'time'              => $faker->time()
            ],
            [
                'name'              => 'TRY OUT NASIONAL 2',
                'difficulty_id'     => Difficulty::all()->random()->id,
                'date_start'        => $faker->dateTime(),
                'date_finish'       => $faker->dateTime(),
                'time'              => $faker->time()
            ]
        ];

        foreach ($data_try_out as $key => $value) {
            $try_out = TryOut::create($value);

            for ($i = 0; $i < 3; $i++) {
                $try_out_question = TryOutQuestion::create([
                    'try_out_id'        => $try_out->id,
                    'question'          => $faker->paragraph(),
                    'question_type_id'  => 1 //PG
                ]);

                for ($j = 0; $j < 4; $j++) {
                    $isTrue = (($j == 0) ? true : false);
                    TryOutAnswer::create([
                        'try_out_question_id'       => $try_out_question->id,
                        'answer'                    => $faker->paragraph(),
                        'is_true'                   => $isTrue
                    ]);
                }
            }

            //pertanyaan ESSAY
            TryOutQuestion::create([
                'try_out_id'        => $try_out->id,
                'question'          => $faker->paragraph(),
                'question_type_id'  => 2 //ESSAY
            ]);
        }
    }
}
