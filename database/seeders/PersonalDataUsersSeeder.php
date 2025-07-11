<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalDataUser;
use App\Models\Representante;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PersonalDataUsersSeeder extends Seeder
{
    public function run()
    {
       
        
        // Obtener representantes para asociar
        $representantes = Representante::all();
        
        $estudiantes = [
            [
                'estudi_nombre' => 'Ana González Pérez',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 27654321,
                // 'representante_id' => $representantes[0]->id,
                'estudi_sexo' => 'Femenino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2010-03-12',
                'estudi_nacimiento_estado' => 'Miranda',
                'estudi_nacimiento_lugar' => 'Hospital de Baruta',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Casa',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 4,
                'estudi_ubi_condiVivienda' => 'Propia pagada',
                'estudi_otros_canaima' => 'Si',
                'estudi_otros_beca' => 'No',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Av. Principal, Residencias Las Flores',
            ],
            [
                'estudi_nombre' => 'José Pérez López',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 28765432,
                // 'representante_id' => $representantes[1]->id,
                'estudi_sexo' => 'Masculino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2011-07-25',
                'estudi_nacimiento_estado' => 'Carabobo',
                'estudi_nacimiento_lugar' => 'Hospital de Valencia',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Casa',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 3,
                'estudi_ubi_condiVivienda' => 'Propia pagandose',
                'estudi_otros_canaima' => 'No',
                'estudi_otros_beca' => 'Si',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Calle 5, Urbanización Los Naranjos',
            ],
            [
                'estudi_nombre' => 'María Rodríguez García',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 29876543,
                // 'representante_id' => $representantes[0]->id,
                'estudi_sexo' => 'Femenino',
                'estudi_lateralidad' => 'Zurdo',
                'estudi_nacimiento' => '2012-05-18',
                'estudi_nacimiento_estado' => 'Miranda',
                'estudi_nacimiento_lugar' => 'Clínica Santa Paula',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Apto',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 5,
                'estudi_ubi_condiVivienda' => 'Alquilada',
                'estudi_otros_canaima' => 'Si',
                'estudi_otros_beca' => 'No',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Av. Libertador, Torre A, Piso 5',
            ],
            [
                'estudi_nombre' => 'Luis Hernández Mendoza',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 30987654,
                // 'representante_id' => $representantes[1]->id,
                'estudi_sexo' => 'Masculino',
                'estudi_lateralidad' => 'Ambidiestro',
                'estudi_nacimiento' => '2009-11-30',
                'estudi_nacimiento_estado' => 'Carabobo',
                'estudi_nacimiento_lugar' => 'Hospital Central de Valencia',
                'estudi_ubi' => 'Barrio',
                'estudi_ubi_tipo' => 'Casa',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 2,
                'estudi_ubi_condiVivienda' => 'Propia pagada',
                'estudi_otros_canaima' => 'No',
                'estudi_otros_beca' => 'Si',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Calle Los Mangos, Barrio San Blas',
            ],
            [
                'estudi_nombre' => 'Carlos Martínez Rojas',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 31098765,
                // 'representante_id' => $representantes[0]->id,
                'estudi_sexo' => 'Masculino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2010-08-15',
                'estudi_nacimiento_estado' => 'Miranda',
                'estudi_nacimiento_lugar' => 'Hospital de Los Ruices',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Casa-quinta',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 4,
                'estudi_ubi_condiVivienda' => 'Propia pagada',
                'estudi_otros_canaima' => 'Si',
                'estudi_otros_beca' => 'No',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Calle El Rosal, Quinta Las Acacias',
            ],
            [
                'estudi_nombre' => 'Sofía Díaz Contreras',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 32109876,
                // 'representante_id' => $representantes[1]->id,
                'estudi_sexo' => 'Femenino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2011-02-28',
                'estudi_nacimiento_estado' => 'Carabobo',
                'estudi_nacimiento_lugar' => 'Hospital de Naguanagua',
                'estudi_ubi' => 'Zona residencial',
                'estudi_ubi_tipo' => 'Casa',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 3,
                'estudi_ubi_condiVivienda' => 'Al cuido',
                'estudi_otros_canaima' => 'No',
                'estudi_otros_beca' => 'No',
                'estudi_otros_alojado' => 'Si',
                'estudi_otros_direccion' => 'Residencias El Parque, Torre 2, Apto 301',
            ],
            [
                'estudi_nombre' => 'Pedro Vargas Suárez',
                'estudi_cedulado' => 'No',
                'estudi_nacionalidad' => 'V',
                'cedula' => 33210987,
                // 'representante_id' => $representantes[0]->id,
                'estudi_sexo' => 'Masculino',
                'estudi_lateralidad' => 'Zurdo',
                'estudi_nacimiento' => '2012-09-10',
                'estudi_nacimiento_estado' => 'Miranda',
                'estudi_nacimiento_lugar' => 'Hospital de Chacao',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Apto-quinta',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 5,
                'estudi_ubi_condiVivienda' => 'Propia pagandose',
                'estudi_otros_canaima' => 'Si',
                'estudi_otros_beca' => 'Si',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Av. Francisco de Miranda, Qta. Los Girasoles',
            ],
            [
                'estudi_nombre' => 'Valentina Sánchez Mora',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'E',
                'cedula' => 34321098,
                // 'representante_id' => $representantes[1]->id,
                'estudi_sexo' => 'Femenino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2010-12-05',
                'estudi_nacimiento_estado' => 'Carabobo',
                'estudi_nacimiento_lugar' => 'Hospital de San Diego',
                'estudi_ubi' => 'Caserio',
                'estudi_ubi_tipo' => 'Rancho rural',
                'estudi_ubi_zona' => 'Rural',
                'estudi_ubi_condiInfra' => 1,
                'estudi_ubi_condiVivienda' => 'Propia pagada',
                'estudi_otros_canaima' => 'No',
                'estudi_otros_beca' => 'Si',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Sector La Esperanza, Vía San Diego',
            ],
            [
                'estudi_nombre' => 'Diego Rivas Gil',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 35432109,
                // 'representante_id' => $representantes[0]->id,
                'estudi_sexo' => 'Masculino',
                'estudi_lateralidad' => 'Derecho',
                'estudi_nacimiento' => '2011-04-22',
                'estudi_nacimiento_estado' => 'Miranda',
                'estudi_nacimiento_lugar' => 'Hospital de Petare',
                'estudi_ubi' => 'Barrio',
                'estudi_ubi_tipo' => 'Rancho barrio',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 2,
                'estudi_ubi_condiVivienda' => 'Propia pagada',
                'estudi_otros_canaima' => 'Si',
                'estudi_otros_beca' => 'No',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Barrio Unión, Calle 5 de Julio',
            ],
            [
                'estudi_nombre' => 'Gabriela Torres Núñez',
                'estudi_cedulado' => 'Si',
                'estudi_nacionalidad' => 'V',
                'cedula' => 36543210,
                // 'representante_id' => $representantes[1]->id,
                'estudi_sexo' => 'Femenino',
                'estudi_lateralidad' => 'Ambidiestro',
                'estudi_nacimiento' => '2012-01-15',
                'estudi_nacimiento_estado' => 'Carabobo',
                'estudi_nacimiento_lugar' => 'Hospital de Guacara',
                'estudi_ubi' => 'Urbanización',
                'estudi_ubi_tipo' => 'Casa',
                'estudi_ubi_zona' => 'Urbana',
                'estudi_ubi_condiInfra' => 4,
                'estudi_ubi_condiVivienda' => 'Propia pagandose',
                'estudi_otros_canaima' => 'No',
                'estudi_otros_beca' => 'Si',
                'estudi_otros_alojado' => 'No',
                'estudi_otros_direccion' => 'Urbanización La Alegría, Calle Los Pinos',
            ]
        ];

      /*  foreach ($estudiantes as $estudianteData) {
            $estudiante = PersonalDataUser::create($estudianteData);
            
            // Crear usuario asociado al estudiante
            $user = User::create([
                'name' => $estudianteData['estudi_nombre'],
                'email' => 'estudiante'.$estudianteData['cedula'].'@example.com',
                'password' => bcrypt('password'), // Contraseña por defecto
            ]);
            
            // Asignar rol de alumno
            $user->assignRole('alumno');
            
            // Opcional: guardar relación entre usuario y estudiante
            $user->personal_data_user_id = $estudiante->id;
            $user->save();
        } */


		DB::beginTransaction();
        try {
            foreach ($estudiantes as $estudianteData) {
                // Seleccionar un representante aleatorio
                $representanteAleatorio = $representantes->random();
                
                // Agregar el representante_id al array de datos
                $estudianteData['representante_id'] = $representanteAleatorio->id;
                
                $estudiante = PersonalDataUser::create($estudianteData);
                
                // Crear usuario asociado al estudiante
                $user = User::create([
                    'name' => $estudianteData['estudi_nombre'],
					'username' => $estudianteData['cedula'],
                    'email' => 'estudiante'.$estudianteData['cedula'].'@example.com',
                    'password' => bcrypt('password'),
                ]);
                
                // Asignar rol de alumno
                $user->assignRole('alumno');
              //   $personal_data = PersonalDataAdmin::create();		
				$estudiante->user()->save($user);
                // Guardar relación entre usuario y estudiante
    //            $user->personal_data_user_id = $estudiante->id;
                $user->save();
                
                // Opcional: Actualizar el contador de estudiantes en el representante
  //              $representanteAleatorio->increment('cantidad_estudiantes');
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error al crear estudiantes: '.$e->getMessage());
        }
    }
}