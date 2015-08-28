<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Vehicle;
use App\Maker;



class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $makerIds = Maker::lists('id')->all();

        foreach (range(1, 30) as $key) {
            DB::table('vehicles')->insert([
                'color' => $faker->safeColorName(),
                'power' => $faker->randomNumber(5),
                'capacity' => $faker->randomFloat(),
                'speed' => $faker->randomFloat(),
                'maker_id' => $faker->randomElement($makerIds)
            ]);
        }

    }
}
