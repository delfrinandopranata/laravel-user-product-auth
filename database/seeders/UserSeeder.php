<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing users
        DB::table('users')->delete();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert the specific user Delfrinando Pranata
        $data = [
            'first_name' => 'Delfrinando',
            'last_name' => 'Pranata',
            'email' => 'delfrinando@gmail.com',
            'password' => Hash::make('123456'),
            'date_of_birth' => '1990-01-01',
            'gender' => 'male', 
        ];
        User::create($data);

        // Testing Dummy Users with factory
        User::factory(20)->create();
    }
}
