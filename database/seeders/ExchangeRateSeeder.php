<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::create(2024, 1, 1);
        $endDate = Carbon::create(2025, 7, 1);

        // Valor inicial simulado del dólar
        $currentRate = 35.50; // Valor inicial ficticio

        // Iterar día por día en el rango
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Saltar sábados y domingos
            if ($date->isWeekend()) {
                continue;
            }

            // Simular pequeñas variaciones diarias en la tasa
            $variation = rand(-50, 50) / 1000; // Pequeña variación entre -0.05 y +0.05
            $currentRate += $variation;

            // Asegurar que la tasa no sea negativa y tenga un mínimo realista
            $currentRate = max($currentRate, 30.00);

            // Crear el registro
            ExchangeRate::create([
                'type' => 'USD',
                'amount' => round($currentRate, 4),
                'created_at' => $date->format('Y-m-d 07:00:00') // Hora laboral ficticia
            ]);
        }
    }
}