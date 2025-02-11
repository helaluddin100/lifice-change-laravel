<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get Bangladesh's country_id
        $countryId = DB::table('countries')->where('name', 'Bangladesh')->value('id');

        // Check if Bangladesh exists before inserting divisions
        if ($countryId) {
            $divisions = [
                ['name' => 'Dhaka', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Chattogram', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Rajshahi', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Khulna', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Barishal', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Sylhet', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Rangpur', 'country_id' => $countryId, 'status' => true],
                ['name' => 'Mymensingh', 'country_id' => $countryId, 'status' => true],
            ];

            DB::table('divisions')->insert($divisions);
        } else {
            // Bangladesh does not exist in the countries table
            echo "Error: Bangladesh not found in countries table. Run CountrySeeder first.\n";
        }
    }
}