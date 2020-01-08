<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EnderecoSeeder::class);
        $this->call(TelefoneSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(CargoSeeder::class);
    }
}
