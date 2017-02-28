<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('questions')->delete();
        for ($i = 0; $i < 20; $i++) {
            DB::table('questions')->insert([
                'title' => str_replace('.', '', $faker->sentence(rand(7, 15))).'?',
                'body' => $faker->text(rand(20, 2500)),
                'user_id' => rand(1, 10),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }
    }
}
