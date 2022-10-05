<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create(50);

        foreach (range(1,50) as $index) {

            DB::table("Customers")->insert([
                "AccountNumber" => $faker->numberBetween(1000000, 9000000),
                "FirstName" => $faker->firstName(),
                "MiddleName" => $faker->lastName(),
                "LastName" => $faker->lastName(),
                "Suffix" => '',
                "Address" => $faker->address,
                "MeterNumber" => $faker->numberBetween(1000, 9000),
                "ConnectionType" => $faker->randomElement(["Residential", "Business"]),
            ]);

        }
    }
}
