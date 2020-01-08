<?php

use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cargos = ['Gerente Administrativo', 'Vendedor(a)', 'Secretário(a)','Atendente','Açougueiro(a)'];
        for($i = 0; $i < count($cargos); $i++){
            DB::table('cargos')->insert([
                'nome'=>$cargos[$i]
            ]);
        }
        
    }
}
