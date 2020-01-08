<?php

use Illuminate\Database\Seeder;
use App\User;
class TelefoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::where('name','Admin')->pluck('id');
        DB::table('telefones')->insert([
            'numero'=>'(54)3281-9189',
            'user_id'=> $user_id[0]
            
        ]);
    }
}
