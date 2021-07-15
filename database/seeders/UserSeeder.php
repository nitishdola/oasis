<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash,DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name'=>'Admin',
            'username'=>'admin',
            'email'=>'webgreeds@gmail.com',
            'password'=>Hash::make('admin123@')
        ]);

    }
}
