<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('comments')->delete();

        for ($i = 0; $i < 50; $i++) {
            DB::table('comments')->insert([
                'body' => $faker->sentence(rand(5, 30)),
                'user_id' => rand(1, 10),
                'question_id' => rand(1, 20),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }

        for ($i = 0; $i < 200; $i++) {
            DB::table('comments')->insert([
                'body' => $faker->sentence(rand(5, 30)),
                'user_id' => rand(1, 10),
                'answer_id' => rand(1, 80),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }
    }
}
