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
        $cargos = [
            'Gerente Administrativo', 
            'Gerente Geral',
            'Vendedor(a)', 
            'Secretário(a)',
            'Atendente',
            'Açougueiro(a)',
            'Salsicheiro(a)',
            'Desossador(a)',
            'Balconista',
        ];
        for($i = 0; $i < count($cargos); $i++){
            DB::table('cargos')->insert([
                'nome'=>$cargos[$i]
            ]);
        }
        
    }
}
