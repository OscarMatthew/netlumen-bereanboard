<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 3000; $i++) {
            DB::table('answers')->insert([
                'body' => $faker->text(rand(40, 500)),
                'user_id' => rand(1, 100),
                'question_id' => rand(1, 1000),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }
    }
}
