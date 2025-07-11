<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\PendingPayment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PendingPaymentSeeder extends Seeder
{
    protected $bankCodes = [
        '0102', // Banesco
        '0104', // Venezuela
        '0105', // Mercantil
        '0108', // Provincial
        '0114', // Bancaribe
        '0115', // Exterior
        '0116', // Occidental de Descuento
        '0128', // Banco del Tesoro
        '0134', // Bicentenario
        '0137', // Sofitasa
        '0138', // Plaza
        '0146', // Banco de Venezuela
        '0151', // 100% Banco
        '0156', // DelSur
        '0157', // Banco del Pueblo Soberano
        '0163', // Banco de Comercio Exterior
        '0166', // Banco Agrícola de Venezuela
        '0168', // Bancrecer
        '0169', // Mi Banco
        '0171', // Activo
        '0172', // Bancamiga
        '0173', // Internacional de Desarrollo
        '0174', // Banplus
        '0175', // BFC Banco Fondo Común
        '0176', // Banco Nacional de Crédito
        '0177', // Banfanb
        '0190', // Citibank
        '0191', // Banco Nacional de Crédito
    ];

    public function run()
    {
        $faker = Faker::create();
        $bankAccounts = BankAccount::all();
        
        // Obtener usuarios que no son admin ni super-admin
        $users = User::whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['admin', 'super-admin']);
        })->get();
        
        // Si no hay usuarios regulares, mostrar advertencia
        if ($users->isEmpty()) {
            $this->command->warn('No se encontraron usuarios sin roles admin/super-admin. No se crearán pagos pendientes.');
            return;
        }

        foreach ($bankAccounts as $account) {
            $pendingCount = rand(5, 15);
            
            for ($i = 0; $i < $pendingCount; $i++) {
                $amount = rand(100, 20000) / 100; // Montos entre 1.00 y 200.00
                $date = now()->subDays(rand(1, 30));
                
                PendingPayment::create([
                    'bank_account_id' => $account->id,
                    'user_id' => $users->random()->id,
                    'reference' => rand(1000000, 9999999),
                    'amount' => $amount,
                    'date' => $date,
                    'code' => $faker->randomElement($this->bankCodes),
                    'status' => $faker->randomElement(['pendiente', 'no encontrado', 'verificado']),
                ]);
            }
        }
    }
}