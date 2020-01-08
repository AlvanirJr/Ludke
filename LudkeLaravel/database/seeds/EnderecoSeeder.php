<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user_id = User::where('name','Admin')->pluck('id');
        DB::table('enderecos')->insert([
            'rua'=>str::random(10),
            'numero'=>'123',
            'bairro'=>str::random(10),
            'cidade'=>str::random(10),
            'uf'=>str::random(2),
            'cep'=>str::random(10),
            'complemento'=>str::random(10),
            'user_id'=> $user_id[0]
        ]);
    }
}
