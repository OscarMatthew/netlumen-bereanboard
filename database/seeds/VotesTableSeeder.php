<?php

use Illuminate\Database\Seeder;

class VotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 2000; $i++) {
            DB::table('votes')->insert([
                'user_id' => rand(1, 100),
                'question_id' => rand(1, 1000),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }

        for ($i = 0; $i < 4000; $i++) {
            DB::table('votes')->insert([
                'user_id' => rand(1, 100),
                'answer_id' => rand(1, 3000),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }

        for ($i = 0; $i < 5000; $i++) {
            DB::table('votes')->insert([
                'user_id' => rand(1, 100),
                'comment_id' => rand(1, 6500),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }
    }
}
