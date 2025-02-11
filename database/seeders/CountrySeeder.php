<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'Bangladesh', 'status' => true],
            ['name' => 'India', 'status' => true],
            ['name' => 'United States', 'status' => true],
            ['name' => 'Canada', 'status' => true],
            ['name' => 'United Kingdom', 'status' => true],
        ];

        DB::table('countries')->insert($countries);
    }
}
