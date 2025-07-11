<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representante;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RepresentantesSeeder extends Seeder
{
    public function run()
    {

        
        $representantes = [
            [
                'nombre' => 'María González',
                'nacionalidad' => 'V',
                'cedula' => 12345678,
                'telefono' => 4123456789,
                'direccion' => 'Av. Principal, Residencias Las Flores',
                'sexo' => 'Femenino',
                'tipo_familiar' => 'Madre',
                'estado_civil' => 'Casado',
                'nacimiento' => '1980-05-15',
                'email' => 'maria.gonzalez@example.com',
                'ubi_estado' => 'Miranda',
                'ubi_municipio' => 'Baruta',
                'ubi_parroquia' => 'Baruta',
                'ubi_via' => 'Av',
                'empleo' => 'Si',
                'empleo_profesion' => 'Contadora',
                'empleo_lugar' => 'Empresa XYZ',
            ],
            [
                'nombre' => 'Carlos Pérez',
                'nacionalidad' => 'V',
                'cedula' => 87654321,
                'telefono' => 4165432198,
                'direccion' => 'Calle 5, Urbanización Los Naranjos',
                'sexo' => 'Masculino',
                'tipo_familiar' => 'Padre',
                'estado_civil' => 'Divorciado',
                'nacimiento' => '1975-08-22',
                'email' => 'carlos.perez@example.com',
                'ubi_estado' => 'Carabobo',
                'ubi_municipio' => 'Valencia',
                'ubi_parroquia' => 'San José',
                'ubi_via' => 'Calle',
                'empleo' => 'Si',
                'empleo_profesion' => 'Ingeniero',
                'empleo_lugar' => 'Constructora ABC',
            ],
            [
                'nombre' => 'Mauro Pérez',
                'nacionalidad' => 'V',
                'cedula' => 5694782,
                'telefono' => 4268856885,
                'direccion' => 'Calle 5, Urbanización villa cariño',
                'sexo' => 'Masculino',
                'tipo_familiar' => 'Padre',
                'estado_civil' => 'Divorciado',
                'nacimiento' => '1970-08-22',
                'email' => 'perez@example.com',
                'ubi_estado' => 'Maracaibo',
                'ubi_municipio' => 'San feernando',
                'ubi_parroquia' => 'San José',
                'ubi_via' => 'Calle',
                'empleo' => 'Si',
                'empleo_profesion' => 'Ingeniero',
                'empleo_lugar' => 'Constructora ABC',
            ],
        ];

        foreach ($representantes as $representanteData) {
            $representante = Representante::create($representanteData);
            
            // Crear usuario asociado al representante
            $user = User::create([
                'name' => $representanteData['nombre'],
                'email' => $representanteData['email'],
				'username'=>$representanteData['cedula'],
                'password' => bcrypt('password'), // Contraseña por defecto
            ]);
            
            // Asignar rol de representante
			
            $user->assignRole('representante');
			$representante->user()->save($user);
            

            $user->save();
        }
    }
}