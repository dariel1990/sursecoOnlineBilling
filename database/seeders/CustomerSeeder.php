<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customers;
use Faker\Generator as Faker;
use App\Models\CustomerBilling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use App\Models\CustomerBillingTransactions;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create(25);

        foreach (range(1,20) as $index) {

            $customer = Customers::create([
                "AccountNumber"     => $faker->numberBetween(1000000, 9000000),
                "FirstName"         => $faker->randomElement(["John", "Benedict", "Prelyn", "Jeffrey", "Shera", "Carmina", "Ann", "May", "Leo", "Leovy", "Chabelita", "Roy" ,"Patrick"]),
                "MiddleName"        => $faker->randomElement(["Ando", "Arones", "Saliva", "Orquina", "Ruadiel", "Hijos", "Intano", "Gotingga", "Rivera", "Lopez", "Cordita", "Millan" ,"Librado", "Coma", "Mira", "Manulat"]),
                "LastName"          => $faker->randomElement(["Ando", "Arones", "Saliva", "Orquina", "Ruadiel", "Hijos", "Intano", "Gotingga", "Rivera", "Lopez", "Cordita", "Millan" ,"Librado", "Coma", "Mira", "Manulat"]),
                "Suffix"            => '',
                "Address"           => $faker->randomElement(["Purok II, Magosilom, Cantilan, SDS",
                                                    "Purok 1, Zone IV, Lanuza, SDS",
                                                    "Purok III, San Vicente, Carmen, SDS",
                                                    "Purok 2, Embarcadero, Carrascal, SDS",
                                                    "Purok V, Panayogon, Madrid, SDS",
                                                    "Purok 1, Zone I, Lanuza, SDS",
                                                    "Purok II, Patong-patong, Madrid, SDS",
                                                    "Purok Gumamela, Poblacion, Carmen, SDS",
                                                    "Gamuton, Carrascal, SDS",
                                                    "Pag-antayan, Cantilan, SDS"]),
                "MeterNumber"       => $faker->numberBetween(1000, 9000),
                "ConnectionType"    => $faker->randomElement(["Residential", "Business"]),
            ]);

            if($index < 10 ){
                $user = User::create([
                    "CustomerId"            => $customer->id,
                    "username"              => 'user'. $index,
                    'password'              => bcrypt('surseco'),
                    'email'                 => $customer->FirstName.''.$customer->LastName.'@gmail.com',
                    'ContactNumber'         => $faker->randomElement(["09516425794", "09426513548". "09486547915", "09064210025", "09095164855"]),
                    "UserRole"              => 1,
                    "email_verified_at"     => $faker->boolean(50) ? Date::now() : null
                ]);
            }

            $previousReading = $faker->numberBetween(500, 10000);

            foreach(range(5,1) as $index){

                $presentReading = $previousReading + $faker->numberBetween(50, 1000);
                $killWattUsed = $presentReading - $previousReading;

                $customerBilling = CustomerBilling::create([
                    "CustomerId"        => $customer->id,
                    "PresentReading"    => $presentReading,
                    "PreviousReading"   => $previousReading,
                    "KiloWattsUsed"     => $killWattUsed,
                    "CurrentBill"       => $killWattUsed * 20,
                    "Arrears"           => 0,
                    "TotalBill"         => $killWattUsed * 20,
                    "BillingPeriodFrom" => Carbon::now()->subMonth($index)->format('Y-m-d'),
                    "BillingPeriodTo"   => Carbon::now()->subMonth($index)->addMonth(1)->format('Y-m-d'),
                    "BillingStatus"     => $index == 1 ? 0 : 1,
                ]);

                $previousReading = $presentReading;

                if($customerBilling->BillingStatus == 1){
                    CustomerBillingTransactions::create([
                        "BillingId"         => $customerBilling->id,
                        "AmountPaid"         => $customerBilling->TotalBill,
                        "TransactionDate"   => Carbon::parse($customerBilling->BillingPeriodTo)->addMonth()->subDays(12)->format('Y-m-d'),
                        "PaymentMethod"     => $faker->randomElement(["Cash/Office", "Online"]),
                    ]);
                }
            }
        }
    }
}
