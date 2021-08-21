<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = new \App\Models\Sistema\Tipo_empresa;
        $tipo->id = 1;
        $tipo->nombre = 'imprenta';
        $tipo->save();

        $tipo = new \App\Models\Sistema\Tipo_empresa;
        $tipo->id = 2;
        $tipo->nombre = 'publicidad';
        $tipo->save();

        $empresa = new \App\Models\Sistema\Empresas;
        $empresa->id = 1709636664001;
        $empresa->tipo_empresa_id = 1;
        $empresa->nombre = 'ServiGraf';
        $empresa->save();

        $empresa = new \App\Models\Sistema\Empresas;
        $empresa->id = 1707255277001;
        $empresa->tipo_empresa_id = 2;
        $empresa->nombre = 'GrupoED';
        $empresa->save();
    }
}
