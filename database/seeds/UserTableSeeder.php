<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('users')->insert([
                'email' => $faker->email,
                'password' => bcrypt('123123')
        ]);

    }
}
