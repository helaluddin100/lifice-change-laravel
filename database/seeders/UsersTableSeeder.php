<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Super Admin',
            'country' => 'Bangladesh',
            'phone' => '01792892198',
            'email' => 'helal@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('helaluddin'),
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'user',
            'country' => 'Bangladesh',
            'phone' => '01792892198',
            'email' => 'helal@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('helaluddin'),
        ]);
        DB::table('users')->insert([
            'role_id' => '3',
            'name' => 'Admin',
            'country' => 'Bangladesh',
            'phone' => '01792892198',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('helaluddin'),
        ]);
        DB::table('users')->insert([
            'role_id' => '4',
            'name' => 'Block User',
            'country' => 'Bangladesh',
            'phone' => '01792892198',
            'email' => 'helal@block.com',
            'email_verified_at' => now(),
            'password' => bcrypt('helaluddin'),
        ]);
    }
}
