<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubscriptionPlanController extends Controller
{
    /**
     * Afficher la page des plans d'abonnement
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Subscription/Plans');
    }

    /**
     * Récupérer tous les plans d'abonnement avec leurs prix
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $plans = SubscriptionPlan::with('currency')
            ->where('is_active', true)
            ->orderBy('monthly_price')
            ->get();

        return response()->json($plans);
    }

    /**
     * Récupérer un plan d'abonnement spécifique
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getById(int $id): JsonResponse
    {
        $plan = SubscriptionPlan::with('currency')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($plan);
    }

    /**
     * Obtenir le prix d'un plan dans une devise spécifique
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPriceInCurrency(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_id' => 'required|integer|exists:subscription_plans,id',
            'currency_code' => 'required|string|size:3',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $plan = SubscriptionPlan::with('currency')
            ->where('id', $validated['plan_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $currency = Currency::where('code', $validated['currency_code'])
            ->where('is_active', true)
            ->firstOrFail();

        $amount = $validated['billing_cycle'] === 'monthly' 
            ? $plan->monthly_price
            : $plan->yearly_price;

        // Si le plan utilise la même devise que celle demandée
        if ($plan->currency_id === $currency->id) {
            $price = $amount;
            $formatted = $currency->formatAmount($amount);
        } else {
            // Convertir le prix dans la devise demandée
            $price = $plan->convertPrice($amount, $currency);
            $formatted = $currency->formatAmount($price);
        }

        return response()->json([
            'original_price' => $amount,
            'original_currency' => $plan->currency->code,
            'converted_price' => $price,
            'currency' => $currency->code,
            'formatted_price' => $formatted,
        ]);
    }

    /**
     * Afficher la page de confirmation d'abonnement
     *
     * @param int $planId ID du plan sélectionné
     * @param Request $request Requête contenant les paramètres
     * @return Response
     */
    public function confirmSubscription(int $planId, Request $request): Response
    {
        // Récupérer le plan d'abonnement
        $plan = SubscriptionPlan::with('currency')
            ->where('id', $planId)
            ->where('is_active', true)
            ->firstOrFail();

        // Récupérer la période de facturation depuis les paramètres
        $billingPeriod = $request->query('billingPeriod', 'monthly');

        // Vérifier que la période est valide
        if (!in_array($billingPeriod, ['monthly', 'annual'])) {
            $billingPeriod = 'monthly';
        }

        // Préparation des données du plan pour l'affichage
        $planData = [
            'id' => $plan->id,
            'name' => $plan->name,
            'description' => $plan->description,
            'price_monthly' => $plan->price_monthly,  // Utiliser le bon nom de colonne
            'price_yearly' => $plan->price_yearly,    // Utiliser le bon nom de colonne
            'currency' => $plan->currency,
            'features' => is_string($plan->features) ? json_decode($plan->features, true) : $plan->features,
            'savingsPercent' => $this->calculateSavingsPercent($plan->price_monthly, $plan->price_yearly) // Ajuster ici aussi
        ];

        // Rendre la vue Confirm avec les données du plan
        return Inertia::render('Subscription/Confirm', [
            'plan' => $planData,
            'billingPeriod' => $billingPeriod,
            'user' => auth()->user()
        ]);
    }

    /**
     * Traiter le paiement de l'abonnement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processSubscription(Request $request): JsonResponse
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'planId' => 'required|integer|exists:subscription_plans,id',
            'billingPeriod' => 'required|in:monthly,annual',
            'paymentMethod' => 'required|string|in:paypal,afrikpay,flutterwave,stripe',
            'billingInfo' => 'required|array',
            'billingInfo.firstName' => 'required|string|max:100',
            'billingInfo.lastName' => 'required|string|max:100',
            'billingInfo.email' => 'required|email|max:100',
            'billingInfo.phone' => 'nullable|string|max:20',
            'customization' => 'nullable|array',
        ]);

        // Récupérer le plan d'abonnement
        $plan = SubscriptionPlan::findOrFail($validated['planId']);
        
        // Déterminer le prix en fonction de la période
        $price = $validated['billingPeriod'] === 'monthly' ? 
            $plan->monthly_price : 
            $plan->yearly_price;

        // Préparer les données pour la passerelle de paiement
        $paymentData = [
            'amount' => $price,
            'currency' => $plan->currency->code,
            'plan_id' => $plan->id,
            'billing_period' => $validated['billingPeriod'],
            'user_id' => auth()->id(),
            'payment_method' => $validated['paymentMethod'],
            'billing_info' => $validated['billingInfo'],
            'customization' => $validated['customization'] ?? null,
        ];

        // Initier la transaction selon la méthode de paiement choisie
        try {
            switch ($validated['paymentMethod']) {
                case 'paypal':
                    // Rediriger vers PayPal pour le paiement
                    $redirectUrl = $this->initiatePaypalPayment($paymentData);
                    return response()->json(['redirect_url' => $redirectUrl]);
                    
                case 'afrikpay':
                    // Rediriger vers Afrikpay pour le paiement
                    $redirectUrl = $this->initiateAfrikpayPayment($paymentData);
                    return response()->json(['redirect_url' => $redirectUrl]);
                    
                case 'flutterwave':
                    // Rediriger vers Flutterwave pour le paiement
                    $redirectUrl = $this->initiateFlutterwavePayment($paymentData);
                    return response()->json(['redirect_url' => $redirectUrl]);
                    
                default:
                    return response()->json(['error' => 'Méthode de paiement non prise en charge'], 400);
            }
        } catch (\Exception $e) {
            // Gérer les exceptions en renvoyant une erreur JSON
            $errorCode = $validated['paymentMethod'] . '_init_failed';
            return response()->json([
                'error' => $errorCode,
                'message' => $e->getMessage(),
                'redirect_url' => route('subscription.payment.error', ['error' => $errorCode])
            ], 500);
        }
    }

    /**
     * Calculer le pourcentage d'économie entre le prix mensuel et annuel
     *
     * @param float|null $monthlyPrice
     * @param float|null $yearlyPrice
     * @return int
     */
    private function calculateSavingsPercent(?float $monthlyPrice, ?float $yearlyPrice): int
    {
        // Si l'un des prix est null ou inférieur ou égal à zéro, on ne peut pas calculer d'économie
        if ($monthlyPrice === null || $yearlyPrice === null || $monthlyPrice <= 0 || $yearlyPrice <= 0) {
            return 0;
        }
        
        $annualAsMonthly = $yearlyPrice / 12;
        return (int) round(((float)$monthlyPrice - (float)$annualAsMonthly) / (float)$monthlyPrice * 100);
    }

    /**
     * Initialiser un paiement PayPal
     * 
     * @param array $paymentData
     * @return string URL de redirection
     */
    private function initiatePaypalPayment(array $paymentData): string
    {
        try {
            // Récupérer le service PayPal
            $paypalService = app(\App\Services\Payment\PaypalService::class);
            
            // Ajouter le nom du plan aux données
            $paymentData['plan_name'] = SubscriptionPlan::find($paymentData['plan_id'])->name ?? 'Plan premium';
            
            // Initialiser le paiement
            $result = $paypalService->initiatePayment($paymentData);
            
            // Vérifier si l'initialisation a réussi
            if ($result['success'] && isset($result['redirect_url'])) {
                // Enregistrer la transaction dans la base de données
                $this->storePaymentTransaction(
                    $paymentData['plan_id'],
                    $paymentData['billing_period'],
                    $paymentData['amount'],
                    $paymentData['currency'],
                    'paypal',
                    $result['payment_id'],
                    $paymentData['user_id']
                );
                
                return $result['redirect_url'];
            }
            
            // En cas d'échec, journaliser l'erreur
            \Illuminate\Support\Facades\Log::error('Erreur d\'initialisation PayPal: ' . json_encode($result));
            
            // Retourner l'URL de la page d'erreur
            return route('subscription.payment.error', ['error' => 'paypal_init_failed']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception lors de l\'initialisation PayPal: ' . $e->getMessage());
            return route('subscription.payment.error', ['error' => 'paypal_exception']);
        }
    }

    /**
     * Initialiser un paiement Afrikpay
     * 
     * @param array $paymentData
     * @return string URL de redirection
     */
    private function initiateAfrikpayPayment(array $paymentData): string
    {
        try {
            // Récupérer le service Afrikpay
            $afrikpayService = app(\App\Services\Payment\AfrikpayService::class);
            
            // Ajouter le nom du plan aux données
            $paymentData['plan_name'] = SubscriptionPlan::find($paymentData['plan_id'])->name ?? 'Plan premium';
            
            // Initialiser le paiement
            $result = $afrikpayService->initiatePayment($paymentData);
            
            // Vérifier si l'initialisation a réussi
            if ($result['success'] && isset($result['redirect_url'])) {
                // Enregistrer la transaction dans la base de données
                $this->storePaymentTransaction(
                    $paymentData['plan_id'],
                    $paymentData['billing_period'],
                    $paymentData['amount'],
                    $paymentData['currency'],
                    'afrikpay',
                    $result['payment_id'],
                    $paymentData['user_id']
                );
                
                return $result['redirect_url'];
            }
            
            // En cas d'échec, journaliser l'erreur
            \Illuminate\Support\Facades\Log::error('Erreur d\'initialisation Afrikpay: ' . json_encode($result));
            
            // Retourner l'URL de la page d'erreur
            return route('subscription.payment.error', ['error' => 'afrikpay_init_failed']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception lors de l\'initialisation Afrikpay: ' . $e->getMessage());
            return route('subscription.payment.error', ['error' => 'afrikpay_exception']);
        }
    }
    
    /**
     * Enregistrer les détails de la transaction de paiement
     *
     * @param int $planId ID du plan d'abonnement
     * @param string $billingPeriod Période de facturation (mensuelle ou annuelle)
     * @param float $amount Montant du paiement
     * @param string $currency Code de la devise
     * @param string $provider Fournisseur de paiement (paypal, afrikpay, etc.)
     * @param string $paymentId ID de la transaction chez le fournisseur
     * @param int $userId ID de l'utilisateur
     * @return bool
     */
    private function storePaymentTransaction(int $planId, string $billingPeriod, float $amount, string $currency, string $provider, string $paymentId, int $userId): bool
    {
        // Cette méthode sera implémentée avec le modèle de transaction
        // Pour l'instant, nous simulons un succès
        return true;
    }
    
    /**
     * Initialiser un paiement Flutterwave
     * 
     * @param array $paymentData
     * @return string URL de redirection
     */
    private function initiateFlutterwavePayment(array $paymentData): string
    {
        try {
            // Récupérer le service Flutterwave
            $flutterwaveService = app(\App\Services\Payment\FlutterwaveService::class);
            
            // Ajouter le nom du plan aux données
            $paymentData['plan_name'] = SubscriptionPlan::find($paymentData['plan_id'])->name ?? 'Plan premium';
            
            // Initialiser le paiement
            $result = $flutterwaveService->initiatePayment($paymentData);
            
            // Vérifier si l'initialisation a réussi
            if ($result['success'] && isset($result['redirect_url'])) {
                // Enregistrer la transaction dans la base de données
                $this->storePaymentTransaction(
                    $paymentData['plan_id'],
                    $paymentData['billing_period'],
                    $paymentData['amount'],
                    $paymentData['currency'],
                    'flutterwave',
                    $result['payment_id'],
                    $paymentData['user_id']
                );
                
                return $result['redirect_url'];
            }
            
            // En cas d'échec, journaliser l'erreur
            \Illuminate\Support\Facades\Log::error('Erreur d\'initialisation Flutterwave: ' . json_encode($result));
            
            // Retourner l'URL de la page d'erreur
            return route('subscription.payment.error', ['error' => 'flutterwave_init_failed']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception lors de l\'initialisation Flutterwave: ' . $e->getMessage());
            return route('subscription.payment.error', ['error' => 'flutterwave_exception']);
        }
    }
    
    /**
     * Afficher la page de succès après un paiement réussi
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function showSuccessPage(Request $request)
    {   
        // Récupérer l'ID de paiement depuis la requête
        $paymentId = $request->input('payment_id');
        
        // TODO: Récupérer les détails de la transaction et de l'abonnement à partir de la base de données
        // Pour l'instant, nous utilisons des données simulées
        $subscriptionData = [
            'payment_id' => $paymentId,
            'plan_name' => 'Plan Premium',
            'billing_period' => 'annuelle',
            'amount' => 10000,
            'currency' => 'XAF',
            'start_date' => now()->format('d/m/Y'),
            'end_date' => now()->addYear()->format('d/m/Y'),
        ];
        
        return Inertia::render('Subscription/Success', [
            'subscription' => $subscriptionData,
        ]);
    }
    
    /**
     * Afficher la page d'erreur de paiement
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function showErrorPage(Request $request)
    {
        $error = $request->input('error', 'unknown_error');
        $message = $request->input('message', 'Une erreur est survenue lors du traitement de votre paiement.');
        
        return Inertia::render('Subscription/Error', [
            'error' => $error,
            'message' => $message,
        ]);
    }
    
    /**
     * Afficher la page d'annulation de paiement
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function showCancelledPage(Request $request)
    {
        $provider = $request->input('provider', 'unknown');
        
        return Inertia::render('Subscription/Cancelled', [
            'provider' => $provider,
        ]);
    }
}
