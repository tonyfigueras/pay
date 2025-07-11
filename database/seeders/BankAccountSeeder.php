<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run()
    {
        $schools = School::all();
        $users = User::all();
        
        foreach ($schools as $school) {
            // Crear 2-3 cuentas bancarias por escuela
            $accountsCount = rand(2, 3);
            
            for ($i = 0; $i < $accountsCount; $i++) {
                $user = $users->random();
                
                BankAccount::create([
                    'n_account' => $this->generateAccountNumber(),
                    'rif' => 'J-' . rand(10000000, 99999999) . '-' . rand(1, 9),
                    'name' => "Cuenta de " . $school->name . " #" . ($i + 1),
                    'email' => 'cuenta' . ($i + 1) . '@' . strtolower(str_replace(' ', '', $school->name)) . '.edu',
                    'type' => ['ahorro', 'corriente'][rand(0, 1)],
                    'code' => strtoupper(substr($school->name, 0, 3)) . rand(1, 9),
                    'school_id' => $school->id,
                ]);
            }
        }
    }
    
    protected function generateAccountNumber(): string
    {
        return implode('-', [
            str_pad(rand(1, 99), 2),
            str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
            str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
            str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
        ]);
    }
}