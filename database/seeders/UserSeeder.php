<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Iqbal',
            'email' => 'julkifli.muhammad@gmail.com',
            'password' => Hash::make('qwerty123'),
            'phone_number' => '082163539497',
            'roles' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
