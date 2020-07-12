<?php

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
        DB::table('users')->insert([
            [
                'name' => 'Adaa Mgbede',
                'email' => 'adaamgbede@gmail.com',
                'user_type' => 'admin',
                'password' => Hash::make('111111')
            ],
            [
                'name' => 'Admin Admin',
                'email' => 'admin@example.com',
                'user_type' => 'admin',
                'password' => Hash::make('111111')
            ],
        ]);
    }
}
