<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Maker;
use App\Vehicle;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Maker::truncate();
        Vehicle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Model::unguard();

        $this->call(MakerTableSeeder::class);
        $this->call(VehicleTableSeeder::class);

        Model::reguard();
    }
}
