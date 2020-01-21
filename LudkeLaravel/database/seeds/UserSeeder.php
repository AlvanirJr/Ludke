<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Endereco;
use App\Telefone;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endereco_id = Endereco::where('numero',123)->pluck('id');
        $telefone_id = Telefone::where('celular','(54)99999-9999')->pluck('id');
        DB::table('users')->insert([
            'name'=> 'Admin',
            'email'=>'admin@gmail.com',
            'tipo'=>'admin',
            'password'=> bcrypt('123456'),
            'endereco_id'=>$endereco_id[0],
            'telefone_id'=>$telefone_id[0],
        ]);
    }
}
