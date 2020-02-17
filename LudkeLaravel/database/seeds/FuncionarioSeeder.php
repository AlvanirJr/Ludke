<?php

use Illuminate\Database\Seeder;
use App\User;

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
        $user = User::find(1);
        DB::table('funcionarios')->insert([
            'user_id'=> $user->id,
            'cargo_id'=> 2,
        ]);
    }
}
