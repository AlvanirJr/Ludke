<?php

use Illuminate\Database\Seeder;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('funcionarios')->insert([
            'user_id'=> 1,
            'cargo_id'=> 2,
        ]);
    }
}
