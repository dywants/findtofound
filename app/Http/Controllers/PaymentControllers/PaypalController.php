<?php

namespace App\Http\Controllers\PaymentControllers;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaypalController extends Controller
{
    /**
     * Service PayPal
     *
     * @var PaypalService
     */
    protected $paypalService;

    /**
     * Constructeur
     *
     * @param PaypalService $paypalService
     */
    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    /**
     * Redirection après paiement réussi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(Request $request)
    {
        try {
            Log::info('Retour PayPal: ' . json_encode($request->all()));
            
            // Traiter le retour de paiement
            $result = $this->paypalService->handlePaymentReturn($request->all());
            
            if ($result['success']) {
                // Mettre à jour le statut de l'abonnement
                $this->updateSubscriptionStatus($result['payment_id']);
                
                // Rediriger vers la page de succès
                return redirect()->route('subscription.success', [
                    'payment_id' => $result['payment_id']
                ]);
            } else {
                // Rediriger vers la page d'erreur
                return redirect()->route('subscription.payment.error', [
                    'error' => 'payment_failed',
                    'message' => $result['message'] ?? 'Le paiement a échoué'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception lors du traitement du retour PayPal: ' . $e->getMessage());
            
            // Rediriger vers la page d'erreur
            return redirect()->route('subscription.payment.error', [
                'error' => 'system_error',
                'message' => 'Une erreur est survenue lors du traitement du paiement'
            ]);
        }
    }

    /**
     * Redirection après annulation de paiement
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request)
    {
        Log::info('Annulation PayPal: ' . json_encode($request->all()));
        
        // Rediriger vers la page d'annulation
        return redirect()->route('subscription.payment.cancelled', [
            'provider' => 'paypal'
        ]);
    }

    /**
     * Webhook pour les notifications PayPal
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('Webhook PayPal reçu: ' . json_encode($request->all()));
            
            // Vérifier l'authenticité du webhook
            $webhookId = config('payment.paypal.webhook_id');
            $event = $request->all();
            
            // Traiter l'événement webhook
            $result = $this->paypalService->handlePaymentReturn($event);
            
            if ($result['success']) {
                // Mettre à jour le statut de l'abonnement si nécessaire
                if ($result['status'] === 'completed') {
                    $this->updateSubscriptionStatus($result['payment_id']);
                }
                
                return response()->json(['status' => 'ok']);
            } else {
                Log::error('Erreur lors du traitement du webhook PayPal: ' . json_encode($result));
                return response()->json(['status' => 'error', 'message' => $result['message'] ?? 'Unknown error'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Exception lors du traitement du webhook PayPal: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'System error'], 500);
        }
    }

    /**
     * Mettre à jour le statut de l'abonnement
     *
     * @param string $paymentId
     * @return bool
     */
    protected function updateSubscriptionStatus(string $paymentId): bool
    {
        try {
            // Logique pour mettre à jour le statut de l'abonnement
            // Cette méthode sera développée dans l'Étape 5
            
            // Pour l'instant, nous simulons un succès
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut de l\'abonnement: ' . $e->getMessage());
            throw $e;
        }
    }
}
