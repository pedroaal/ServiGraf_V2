<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Administracion\Horario;
use App\Models\Sistema\CentroCostos;
use App\Models\Sistema\Nomina;
use App\Models\Usuarios\Perfil;
use App\Models\Usuarios\Usuario;

class UsuariosSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //horario
    $horario = new Horario();
    $horario->id = 1;
    $horario->empresa_id = 1709636664001;
    $horario->nombre = 'Matutino';
    $horario->llegada_ma = '09:00';
    $horario->salida_ma = '13:00';
    $horario->llegada_ta = '14:00';
    $horario->salida_ta = '18:00';
    $horario->save();

    //centro de costos
    $ccostos = new CentroCostos();
    $ccostos->empresa_id = 1709636664001;
    $ccostos->nombre = 'Centro de costos test';
    $ccostos->save();

    // perfil admin
    $perfil = new Perfil();
    $perfil->id = 1;
    $perfil->empresa_id = 1709636664001;
    $perfil->nombre = 'RootPerf';
    $perfil->descripcion = 'Perfil de desarrollo';
    $perfil->save();

    // perfil demo
    $perfil = new Perfil();
    $perfil->id = 2;
    $perfil->empresa_id = 1719953281001;
    $perfil->nombre = 'DemoPerf';
    $perfil->descripcion = 'Perfil de demostración';
    $perfil->save();

    //nomina
    $nomina = new Nomina();
    $nomina->empresa_id = 1709636664001;
    $nomina->cedula = 1010101010;
    $nomina->fecha_nacimiento = '2020-01-01';
    $nomina->lugar_nacimiento = 'Quito';
    $nomina->nacionalidad = 'ecuatoriano';
    $nomina->idioma_nativo = 'Espanol';
    $nomina->nombre = 'RootNomina';
    $nomina->apellido = 'ApellNomina';
    $nomina->direccion = 'La calle y la que crusa';
    $nomina->sector = 'Barrio';
    $nomina->telefono = 7777777;
    $nomina->celular = 999999999;
    $nomina->correo = 'root@nomina.com';
    $nomina->tipo_sangre = 1;
    $nomina->genero = 1;
    $nomina->estado_civil = 1;
    $nomina->inicio_labor = '2020-01-01';
    $nomina->cargo = 'Administrador';
    $nomina->centro_costos_id = 1;
    $nomina->iess_asumido_empleador = 1;
    $nomina->sueldo = 2000.00;
    $nomina->banco_id = 0;
    $nomina->tipo_cuenta_banco = 0;
    $nomina->numero_cuenta_bancaria = 123456789;
    $nomina->horario_id = 1;
    $nomina->save();

    //usuario
    $usuario = new Usuario();
    $usuario->cedula = 1010101010;
    $usuario->empresa_id = 1709636664001;
    $usuario->usuario = 'RootUser';
    $usuario->password = Hash::make('123456');
    $usuario->perfil_id = 1;
    $usuario->save();

    //nomina
    $nomina = new Nomina();
    $nomina->empresa_id = 1709636664001;
    $nomina->cedula = 1709636664;
    $nomina->fecha_nacimiento = '1967-01-19';
    $nomina->lugar_nacimiento = 'Quito';
    $nomina->nacionalidad = 'ecuatoriano';
    $nomina->idioma_nativo = 'Espanol';
    $nomina->nombre = 'Samuel';
    $nomina->apellido = 'Altamirano';
    $nomina->direccion = 'La calle y la que crusa';
    $nomina->sector = 'Barrio';
    $nomina->telefono = 7777777;
    $nomina->celular = 999999999;
    $nomina->correo = 'samuel_ap@hotmail.com';
    $nomina->tipo_sangre = 1;
    $nomina->genero = 1;
    $nomina->estado_civil = 1;
    $nomina->inicio_labor = '2020-01-01';
    $nomina->cargo = 'Administrador';
    $nomina->centro_costos_id = 1;
    $nomina->iess_asumido_empleador = 1;
    $nomina->sueldo = 2000.00;
    $nomina->banco_id = 0;
    $nomina->tipo_cuenta_banco = 0;
    $nomina->numero_cuenta_bancaria = 123456789;
    $nomina->horario_id = 1;
    $nomina->save();

    //usuario
    $usuario = new Usuario();
    $usuario->cedula = 1709636664;
    $usuario->empresa_id = 1709636664001;
    $usuario->usuario = 'Samuel';
    $usuario->password = Hash::make('SaMueL7691');
    $usuario->perfil_id = 1;
    $usuario->save();

    //nomina
    $nomina = new Nomina();
    $nomina->empresa_id = 1707255277001;
    $nomina->cedula = 1707255277;
    $nomina->fecha_nacimiento = '1963-09-17';
    $nomina->lugar_nacimiento = 'Quito';
    $nomina->nacionalidad = 'ecuatoriano';
    $nomina->idioma_nativo = 'Espanol';
    $nomina->nombre = 'Daniel';
    $nomina->apellido = 'Altamirano';
    $nomina->direccion = 'La calle y la que crusa';
    $nomina->sector = 'Barrio';
    $nomina->telefono = 7777777;
    $nomina->celular = 999999999;
    $nomina->correo = 'danielapi@yahoo.com';
    $nomina->tipo_sangre = 1;
    $nomina->genero = 1;
    $nomina->estado_civil = 1;
    $nomina->inicio_labor = '2020-01-01';
    $nomina->cargo = 'Administrador';
    $nomina->centro_costos_id = 1;
    $nomina->iess_asumido_empleador = 1;
    $nomina->sueldo = 2000.00;
    $nomina->banco_id = 0;
    $nomina->tipo_cuenta_banco = 0;
    $nomina->numero_cuenta_bancaria = 123456789;
    $nomina->horario_id = 1;
    $nomina->save();

    //usuario
    $usuario = new Usuario();
    $usuario->cedula = 1707255277;
    $usuario->empresa_id = 1707255277001;
    $usuario->usuario = 'Daniel';
    $usuario->password = Hash::make('123456');
    $usuario->perfil_id = 1;
    $usuario->save();

    //nomina
    $nomina = new Nomina();
    $nomina->empresa_id = 1719953281001;
    $nomina->cedula = 1010101011;
    $nomina->fecha_nacimiento = '2020-01-01';
    $nomina->lugar_nacimiento = 'Quito';
    $nomina->nacionalidad = 'ecuatoriano';
    $nomina->idioma_nativo = 'Espanol';
    $nomina->nombre = 'Demo Nomina';
    $nomina->apellido = 'Apell Nomina';
    $nomina->direccion = 'La calle y la que crusa';
    $nomina->sector = 'Barrio';
    $nomina->telefono = 7777777;
    $nomina->celular = 999999999;
    $nomina->correo = 'demo@nomina.com';
    $nomina->tipo_sangre = 1;
    $nomina->genero = 1;
    $nomina->estado_civil = 1;
    $nomina->inicio_labor = '2020-01-01';
    $nomina->cargo = 'Ventas';
    $nomina->centro_costos_id = 1;
    $nomina->iess_asumido_empleador = 1;
    $nomina->sueldo = 800.00;
    $nomina->banco_id = 0;
    $nomina->tipo_cuenta_banco = 0;
    $nomina->numero_cuenta_bancaria = 123456789;
    $nomina->horario_id = 1;
    $nomina->save();

    //usuario
    $usuario = new Usuario();
    $usuario->cedula = 1010101011;
    $usuario->empresa_id = 1719953281001;
    $usuario->usuario = 'Demo';
    $usuario->password = Hash::make('123456');
    $usuario->perfil_id = 2;
    $usuario->save();
  }
}
