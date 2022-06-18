<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table( 'users' )->insert( array(
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'address'  => 'Yangon',
            'phone'    => '09883246',
            'role'     => 'admin',
            'password' => Hash::make( 'admin123' ),
        ) );
    }
}
