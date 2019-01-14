<?php

use Illuminate\Database\Seeder;
use App\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city1 = new City;
        $city1->name = "Mekka";
        $city1->save();

        $city2 = new City;
        $city2->name = "Madinah";
        $city2->save();

        $city3 = new City;
        $city3->name = "Geddah";
        $city3->save();

        $city4 = new City;
        $city4->name = "Riyadh";
        $city4->save();
    }
}
