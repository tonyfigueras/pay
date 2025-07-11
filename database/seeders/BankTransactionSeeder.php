<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BankTransactionSeeder extends Seeder
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
        $users = User::all();
        
        foreach ($bankAccounts as $account) {
            $transactionsCount = rand(10, 30);
            
            for ($i = 0; $i < $transactionsCount; $i++) {
                $amount = rand(100, 500000) / 100; // Montos entre 1.00 y 5000.00
                $date = now()->subDays(rand(1, 90));
                
                BankTransaction::create([
                    'bank_account_id' => $account->id,
                    'user_id' => rand(0, 1) ? $users->random()->id : null,
                    'reference' => rand(100000000, 999999999),
                    'concepto' => rand(1, 20),
                    'amount' => $amount,
                    'date' => $date,
                    'code' => $faker->randomElement($this->bankCodes),
                ]);
            }
        }
    }
}