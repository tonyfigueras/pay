<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = [
            [
                'name' => 'Colegio San Agustín',
                'code' => 'CSA-001',
                'rif' => 'J-12345678-1',
                'email' => 'info@sanagustin.edu',
                'phone' => '02121234567',
                'address' => 'Av. Principal de La Florida, Caracas'
            ],
            [
                'name' => 'Unidad Educativa Los Arcos',
                'code' => 'UELA-002',
                'rif' => 'J-23456789-2',
                'email' => 'contacto@losarcos.edu',
                'phone' => '02122345678',
                'address' => 'Calle Los Arcos, El Marqués, Caracas'
            ],
            [
                'name' => 'Colegio La Salle',
                'code' => 'CLS-003',
                'rif' => 'J-34567890-3',
                'email' => 'administracion@lasalle.edu',
                'phone' => '02123456789',
                'address' => 'Av. Boyacá, La Florida, Caracas'
            ],
            [
                'name' => 'Instituto Educativo San Ignacio',
                'code' => 'IESI-004',
                'rif' => 'J-45678901-4',
                'email' => 'secretaria@saningnacio.edu',
                'phone' => '02124567890',
                'address' => 'Urbanización La Castellana, Caracas'
            ],
            [
                'name' => 'Colegio Los Caobos',
                'code' => 'CLC-005',
                'rif' => 'J-56789012-5',
                'email' => 'info@colegioloscaobos.edu',
                'phone' => '02125678901',
                'address' => 'Av. Principal de Los Caobos, Caracas'
            ],
            [
                'name' => 'Escuela Técnica Don Bosco',
                'code' => 'ETDB-006',
                'rif' => 'J-67890123-6',
                'email' => 'contacto@donbosco.edu',
                'phone' => '02126789012',
                'address' => 'Av. Libertador, Caracas'
            ],
            [
                'name' => 'Colegio Humboldt',
                'code' => 'CH-007',
                'rif' => 'J-78901234-7',
                'email' => 'info@humboldt.edu',
                'phone' => '02127890123',
                'address' => 'Colinas de Valle Arriba, Caracas'
            ],
            [
                'name' => 'Unidad Educativa Santa María',
                'code' => 'UESM-008',
                'rif' => 'J-89012345-8',
                'email' => 'santamaria@uesm.edu',
                'phone' => '02128901234',
                'address' => 'Av. Panteón, San Bernardino, Caracas'
            ],
            [
                'name' => 'Colegio Francia',
                'code' => 'CF-009',
                'rif' => 'J-90123456-9',
                'email' => 'contacto@colegiofrancia.edu',
                'phone' => '02129012345',
                'address' => 'La Tahona, Caracas'
            ],
            [
                'name' => 'Instituto Escuela',
                'code' => 'IE-010',
                'rif' => 'J-01234567-0',
                'email' => 'administracion@institutoescuela.edu',
                'phone' => '02120123456',
                'address' => 'Av. Principal de Las Mercedes, Caracas'
            ]
        ];

        foreach ($schools as $school) {
            School::create($school);
        }
    }
}