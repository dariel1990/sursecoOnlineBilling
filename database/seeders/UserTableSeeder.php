<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //for Admin Account
        User::create([
            'CustomerId' => null,
            'Username' => 'admin',
            'Password' => bcrypt('surseco'),
            'Email' => 'sursecoBilling@gmail.com',
            'ContactNumber' => '09062215494',
            'UserRole' => 0,
        ]);
    }
}
