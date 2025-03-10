<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class PaypalService implements PaymentServiceInterface
{
    /**
     * L'URL de base de l'API PayPal (pour le mode sandbox ou production)
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Client ID pour l'authentification OAuth
     *
     * @var string
     */
    protected $clientId;

    /**
     * Secret pour l'authentification OAuth
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Token d'accès pour les requêtes API
     *
     * @var string|null
     */
    protected $accessToken = null;

    /**
     * Constructeur du service PayPal
     */
    public function __construct()
    {
        $this->baseUrl = config('payment.paypal.sandbox') 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
        
        $this->clientId = config('payment.paypal.client_id');
        $this->clientSecret = config('payment.paypal.client_secret');
    }

    /**
     * Obtenir un token d'accès OAuth pour les appels API
     *
     * @return string
     * @throws Exception
     */
    protected function getAccessToken(): string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        try {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->asForm()
                ->post("$this->baseUrl/v1/oauth2/token", [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                $this->accessToken = $response->json('access_token');
                return $this->accessToken;
            }

            throw new Exception('Échec de l\'obtention du token PayPal: ' . $response->body());
        } catch (Exception $e) {
            Log::error('Erreur PayPal getAccessToken: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Initialiser un paiement avec PayPal
     *
     * @param array $paymentData Données nécessaires pour initier le paiement
     * @return array Tableau contenant les informations de redirection
     * @throws Exception
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            $token = $this->getAccessToken();
            
            // Formatage des données pour la création d'un ordre
            $orderPayload = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => 'plan_' . $paymentData['plan_id'],
                        'description' => 'Abonnement plan: ' . $paymentData['plan_name'],
                        'amount' => [
                            'currency_code' => $paymentData['currency'],
                            'value' => number_format($paymentData['amount'], 2, '.', ''),
                        ]
                    ]
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('paypal.return'),
                    'cancel_url' => route('paypal.cancel')
                ]
            ];

            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("$this->baseUrl/v2/checkout/orders", $orderPayload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Stocker les informations de transaction
                // TODO: Enregistrer les détails de transaction dans la base de données
                
                // Trouver le lien de redirection d'approbation
                $approveUrl = '';
                foreach ($data['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approveUrl = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'payment_id' => $data['id'],
                    'redirect_url' => $approveUrl,
                    'status' => $data['status'],
                    'provider' => 'paypal'
                ];
            }

            Log::error('Échec de création d\'ordre PayPal: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de création d\'ordre PayPal',
                'error' => $response->json()
            ];
        } catch (Exception $e) {
            Log::error('Erreur PayPal initiatePayment: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement PayPal',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Capturer un paiement autorisé
     *
     * @param string $orderId ID de l'ordre à capturer
     * @return array Résultat de la capture
     */
    public function capturePayment(string $orderId): array
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->post("$this->baseUrl/v2/checkout/orders/$orderId/capture");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'payment_id' => $orderId,
                    'transaction_id' => $data['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                    'status' => $data['status'],
                    'data' => $data
                ];
            }

            Log::error('Échec de capture PayPal: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de capture du paiement',
                'error' => $response->json()
            ];
        } catch (Exception $e) {
            Log::error('Erreur PayPal capturePayment: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la capture du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     *
     * @param string $paymentId Identifiant du paiement à vérifier
     * @return array Tableau contenant les informations sur le statut du paiement
     */
    public function checkPaymentStatus(string $paymentId): array
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get("$this->baseUrl/v2/checkout/orders/$paymentId");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'status' => $data['status'],
                    'data' => $data
                ];
            }

            Log::error('Échec de vérification du statut PayPal: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de vérification du statut du paiement',
                'error' => $response->json()
            ];
        } catch (Exception $e) {
            Log::error('Erreur PayPal checkPaymentStatus: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Gérer le retour de paiement (webhook ou redirection)
     *
     * @param array $data Données reçues lors du retour de paiement
     * @return array Résultat du traitement
     */
    public function handlePaymentReturn(array $data): array
    {
        // Si la requête vient d'une redirection utilisateur
        if (isset($data['token']) && isset($data['PayerID'])) {
            return $this->handleUserReturn($data);
        }
        
        // Si c'est un webhook PayPal
        return $this->handleWebhookEvent($data);
    }

    /**
     * Traiter le retour utilisateur après paiement
     *
     * @param array $data
     * @return array
     */
    protected function handleUserReturn(array $data): array
    {
        if (!isset($data['token'])) {
            return [
                'success' => false,
                'message' => 'Token de paiement manquant'
            ];
        }

        // Capturer le paiement
        return $this->capturePayment($data['token']);
    }

    /**
     * Traiter un événement webhook de PayPal
     *
     * @param array $data
     * @return array
     */
    protected function handleWebhookEvent(array $data): array
    {
        $eventType = $data['event_type'] ?? '';
        $resourceId = $data['resource']['id'] ?? null;

        switch ($eventType) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                // Paiement capturé avec succès
                // Mettre à jour le statut de l'abonnement
                return [
                    'success' => true,
                    'status' => 'completed',
                    'payment_id' => $resourceId
                ];

            case 'PAYMENT.CAPTURE.DENIED':
            case 'PAYMENT.CAPTURE.DECLINED':
            case 'PAYMENT.CAPTURE.FAILED':
                // Échec de paiement
                return [
                    'success' => false,
                    'status' => 'failed',
                    'payment_id' => $resourceId
                ];

            default:
                // Autre type d'événement
                return [
                    'success' => true,
                    'status' => 'unknown',
                    'event_type' => $eventType,
                    'payment_id' => $resourceId
                ];
        }
    }
}
