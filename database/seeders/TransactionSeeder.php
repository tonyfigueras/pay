<?php

namespace Database\Seeders;

use App\Models\BankTransaction;
use App\Models\PendingPayment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        
        foreach ($users as $user) {
            $wallet = $user->wallet;
            $transactionsCount = rand(5, 20);
            
            for ($i = 0; $i < $transactionsCount; $i++) {
                $amount = rand(100, 10000) / 100; // Montos entre 1.00 y 100.00
                $previousBalance = $wallet->balance;
                
                // Tipos de transacción según la migración
                $type = ['deuda pagada', 'transferencia de saldo', 'pago verificado', 'manual'][rand(0, 3)];
                $paymentMethod = ['transferencia o depósito bancario', 'saldo disponible', 'exonerado', 'otros'][rand(0, 3)];
                $exonerado = $paymentMethod === 'exonerado' ? 1 : 0;
                
                // Payload de ejemplo
                $payload = [
                    'description' => "Transacción de ejemplo #" . ($i + 1),
                    'reference' => 'REF-' . strtoupper(substr($user->name, 0, 3)) . rand(1000, 9999),
                    'details' => [
                        'service' => ['Matrícula', 'Mensualidad', 'Materiales', 'Actividad'][rand(0, 3)],
                        'invoice_number' => 'FACT-' . rand(1000, 9999),
                    ]
                ];
                
                // Crear transacción
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'payload' => $payload,
                    'amount' => $amount,
                    'previous_balance' => $previousBalance,
                    'payment_method' => $paymentMethod,
                    'exonerado' => $exonerado,
                ]);
                
                // Actualizar balance de la wallet si corresponde
                if (in_array($type, ['deuda pagada', 'pago verificado', 'transferencia de saldo'])) {
                    $wallet->balance += $amount;
                    $wallet->save();
                }
                
                // Relacionar con BankTransaction si existe (30% de probabilidad)
                if (rand(1, 100) <= 30) {
                    $bankTransaction = BankTransaction::inRandomOrder()->first();
                    if ($bankTransaction) {
                        $transaction->transable()->associate($bankTransaction);
                        $transaction->save();
                    }
                }
                
                // Relacionar con PendingPayment si es un pago verificado (20% de probabilidad)
                if ($type === 'pago verificado' && rand(1, 100) <= 20) {
                    $pendingPayment = PendingPayment::inRandomOrder()->first();
                    if ($pendingPayment) {
                        $transaction->transable()->associate($pendingPayment);
                        $transaction->save();
                    }
                }
            }
        }
    }
}