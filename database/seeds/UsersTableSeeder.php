<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $roles = ['user', 'moderator'];

        for ($i = 0; $i < 100; $i++) {
            DB::table('users')->insert([
                'username' => $faker->firstName().$faker->lastName(),
                'email' => $faker->email(),
                'role' => $roles[rand(0, 1)],
                'password' => bcrypt('asdfasdf'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }

        DB::table('users')->insert([
            'username' => 'user',
            'email' => 'user@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('asdfasdf'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
    }
}
