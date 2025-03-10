<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * Récupérer la liste des devises actives.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $currencies = Currency::where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('code')
            ->get(['id', 'code', 'name', 'symbol', 'exchange_rate', 'is_default', 'decimal_places']);
            
        return response()->json($currencies);
    }

    /**
     * Récupérer les taux de change actuels.
     * 
     * @return JsonResponse
     */
    public function getRates(): JsonResponse
    {
        $rates = Currency::where('is_active', true)
            ->get(['code', 'exchange_rate'])
            ->pluck('exchange_rate', 'code');
            
        return response()->json([
            'base' => 'EUR',
            'timestamp' => now()->timestamp,
            'rates' => $rates,
        ]);
    }

    /**
     * Récupérer une devise spécifique par son code.
     * 
     * @param string $code Code de la devise (XAF, EUR, etc.)
     * @return JsonResponse
     */
    public function show(string $code): JsonResponse
    {
        $currency = Currency::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail(['id', 'code', 'name', 'symbol', 'exchange_rate', 'is_default', 'decimal_places']);
            
        return response()->json($currency);
    }

    /**
     * Convertir un montant d'une devise à une autre.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function convert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
        ]);
        
        $amount = $validated['amount'];
        $fromCode = strtoupper($validated['from']);
        $toCode = strtoupper($validated['to']);
        
        // Récupérer les devises source et cible
        $from = Currency::where('code', $fromCode)->where('is_active', true)->first();
        $to = Currency::where('code', $toCode)->where('is_active', true)->first();
        
        if (!$from || !$to) {
            return response()->json([
                'error' => 'Devise non trouvée ou inactive',
            ], 404);
        }
        
        // Convertir le montant
        // Convertir en EUR (devise de base) puis dans la devise cible
        $amountInEur = $amount / $from->exchange_rate;
        $convertedAmount = $amountInEur * $to->exchange_rate;
        
        // Arrondir selon les conventions de la devise cible
        $convertedAmount = round($convertedAmount, $to->decimal_places);
        
        return response()->json([
            'from' => $fromCode,
            'to' => $toCode,
            'amount' => $amount,
            'converted' => $convertedAmount,
            'formatted' => $to->formatAmount($convertedAmount),
        ]);
    }
}
