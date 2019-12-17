<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name'=> str::random(10),
            'email'=>'admin@gmail.com',
            'tipo'=>'admin',
            'password'=> bcrypt('123456'),
        ]);
    }
}