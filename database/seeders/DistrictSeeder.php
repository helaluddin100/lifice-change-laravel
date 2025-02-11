<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
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

        if (!$countryId) {
            echo "Error: Bangladesh not found in countries table. Run CountrySeeder first.\n";
            return;
        }

        // Get division IDs dynamically
        $divisions = DB::table('divisions')->where('country_id', $countryId)->pluck('id', 'name');

        // Districts grouped by division
        $districts = [
            'Dhaka' => ['Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj', 'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur', 'Tangail'],
            'Chattogram' => ['Bandarban', 'Brahmanbaria', 'Chandpur', 'Chattogram', 'Coxsbazar', 'Cumilla', 'Feni', 'Khagrachari', 'Lakshmipur', 'Noakhali', 'Rangamati'],
            'Rajshahi' => ['Bogura', 'Joypurhat', 'Naogaon', 'Natore', 'Chapainawabganj', 'Pabna', 'Rajshahi', 'Sirajganj'],
            'Khulna' => ['Bagerhat', 'Chuadanga', 'Jashore', 'Jhenaidah', 'Khulna', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'],
            'Barishal' => ['Barguna', 'Barishal', 'Bhola', 'Jhalakathi', 'Patuakhali', 'Pirojpur'],
            'Sylhet' => ['Habiganj', 'Moulvibazar', 'Sunamganj', 'Sylhet'],
            'Rangpur' => ['Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 'Panchagarh', 'Rangpur', 'Thakurgaon'],
            'Mymensingh' => ['Jamalpur', 'Mymensingh', 'Netrokona', 'Sherpur'],
        ];

        // Insert districts
        foreach ($districts as $divisionName => $districtList) {
            if (isset($divisions[$divisionName])) {
                $divisionId = $divisions[$divisionName];

                foreach ($districtList as $district) {
                    DB::table('districts')->updateOrInsert([
                        'name' => $district,
                        'country_id' => $countryId,
                        'division_id' => $divisionId,
                    ], [
                        'status' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
