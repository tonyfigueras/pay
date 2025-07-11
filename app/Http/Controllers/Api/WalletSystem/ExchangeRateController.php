<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ExchangeRateController extends Controller
{
    /**
     * Muestra una lista de las tasas de cambio guardadas
     */
    public function index()
    {
        $rates = ExchangeRate::orderBy('created_at', 'desc')->get();
        return response()->json($rates);
    }

    /**
     * Consume el API de DolarAPI y guarda la tasa oficial
     */
    public function fetchAndStoreOfficialRate()
    {
        try {
            // Consumir el endpoint
            $response = Http::get('https://ve.dolarapi.com/v1/dolares/oficial');
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Validar que los datos necesarios estén presentes
                if (isset($data['promedio']) && isset($data['fechaActualizacion'])) {
                    // Crear nuevo registro en la base de datos
                    $exchangeRate = ExchangeRate::create([
                        'type' => 'usd',
                        'amount' => $data['promedio'],
                        'created_at' => Carbon::parse($data['fechaActualizacion'])->format('Y-m-d H:i:s')
                    ]);
                    
                    return response()->json([
                        'message' => 'Tasa de cambio guardada exitosamente',
                        'data' => $exchangeRate
                    ], 201);
                } else {
                    return response()->json([
                        'error' => 'Los datos del API no tienen el formato esperado'
                    ], 400);
                }
            } else {
                return response()->json([
                    'error' => 'No se pudo obtener la tasa de cambio del API'
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
}