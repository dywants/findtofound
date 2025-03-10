<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class FlutterwaveService implements PaymentServiceInterface
{
    /**
     * L'URL de base de l'API Flutterwave
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Clé secrète pour l'authentification
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Clé publique pour l'authentification côté client
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Préfixe des références de transaction
     *
     * @var string
     */
    protected $txRefPrefix = 'FTOF_FLW_';

    /**
     * Constructeur du service Flutterwave
     */
    public function __construct()
    {
        $this->baseUrl = config('payment.flutterwave.sandbox')
            ? 'https://api.flutterwave.com/v3'
            : 'https://api.flutterwave.com/v3';
        
        $this->secretKey = config('payment.flutterwave.secret_key');
        $this->publicKey = config('payment.flutterwave.public_key');
    }

    /**
     * Générer une référence de transaction unique
     *
     * @param array $paymentData
     * @return string
     */
    protected function generateTransactionReference(array $paymentData): string
    {
        return $this->txRefPrefix . time() . '_' . $paymentData['plan_id'] . '_' . $paymentData['user_id'];
    }

    /**
     * Initialiser un paiement avec Flutterwave
     *
     * @param array $paymentData Données nécessaires pour initier le paiement
     * @return array Tableau contenant les informations de redirection
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            // Générer une référence de transaction unique
            $txRef = $this->generateTransactionReference($paymentData);
            
            // Préparer les données pour la requête
            $requestData = [
                'tx_ref' => $txRef,
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'redirect_url' => route('flutterwave.return'),
                'payment_options' => 'card,mobilemoneyfranco,bank',
                'meta' => [
                    'plan_id' => $paymentData['plan_id'],
                    'billing_period' => $paymentData['billing_period'],
                    'user_id' => $paymentData['user_id']
                ],
                'customer' => [
                    'email' => $paymentData['billing_info']['email'] ?? '',
                    'phonenumber' => $paymentData['billing_info']['phone'] ?? '',
                    'name' => ($paymentData['billing_info']['firstName'] ?? '') . ' ' . ($paymentData['billing_info']['lastName'] ?? '')
                ],
                'customizations' => [
                    'title' => 'Abonnement FindToFound',
                    'description' => 'Paiement pour ' . ($paymentData['plan_name'] ?? 'Plan premium'),
                    'logo' => config('app.url') . '/img/logo.png'
                ]
            ];
            
            // Envoyer la requête à Flutterwave
            $response = Http::withToken($this->secretKey)
                ->post("$this->baseUrl/payments", $requestData);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Vérifier si l'initialisation a réussi
                if ($data['status'] === 'success') {
                    return [
                        'success' => true,
                        'payment_id' => $txRef,
                        'redirect_url' => $data['data']['link'],
                        'status' => 'pending',
                        'provider' => 'flutterwave'
                    ];
                } else {
                    Log::error('Échec d\'initialisation Flutterwave: ' . json_encode($data));
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Échec d\'initialisation du paiement',
                        'error' => $data
                    ];
                }
            }
            
            Log::error('Échec de réponse Flutterwave: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de communication avec Flutterwave',
                'error' => $response->json() ?? $response->body()
            ];
        } catch (Exception $e) {
            Log::error('Erreur Flutterwave initiatePayment: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement Flutterwave',
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
            // Envoyer la requête à Flutterwave pour vérifier la transaction par référence
            $response = Http::withToken($this->secretKey)
                ->get("$this->baseUrl/transactions/verify_by_reference?tx_ref={$paymentId}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    $transaction = $data['data'];
                    
                    // Mapper le statut Flutterwave à notre format interne
                    $status = $this->mapFlutterwaveStatus($transaction['status']);
                    
                    return [
                        'success' => true,
                        'status' => $status,
                        'data' => $transaction
                    ];
                } else {
                    Log::error('Échec de vérification du statut Flutterwave: ' . json_encode($data));
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Échec de vérification du statut',
                        'error' => $data
                    ];
                }
            }
            
            Log::error('Échec de réponse Flutterwave check status: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de communication avec Flutterwave',
                'error' => $response->json() ?? $response->body()
            ];
        } catch (Exception $e) {
            Log::error('Erreur Flutterwave checkPaymentStatus: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification du statut du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Mapper le statut Flutterwave à notre format interne
     *
     * @param string $flwStatus
     * @return string
     */
    protected function mapFlutterwaveStatus(string $flwStatus): string
    {
        switch (strtolower($flwStatus)) {
            case 'successful':
                return 'completed';
            case 'failed':
                return 'failed';
            case 'cancelled':
                return 'cancelled';
            case 'pending':
                return 'pending';
            default:
                return 'unknown';
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
        try {
            // Pour les webhooks, vérifier la signature
            if (isset($data['verif_hash'])) {
                $receivedHash = $data['verif_hash'];
                $secretHash = config('payment.flutterwave.webhook_hash');
                
                if ($receivedHash !== $secretHash) {
                    Log::error('Signature webhook Flutterwave invalide');
                    return [
                        'success' => false,
                        'message' => 'Signature invalide',
                        'status' => 'invalid'
                    ];
                }
            }
            
            // Pour les redirections, vérifier le statut via l'API
            if (isset($data['tx_ref'])) {
                $paymentId = $data['tx_ref'];
                $statusResult = $this->checkPaymentStatus($paymentId);
                
                if ($statusResult['success']) {
                    return [
                        'success' => true,
                        'status' => $statusResult['status'],
                        'payment_id' => $paymentId,
                        'data' => $statusResult['data']
                    ];
                } else {
                    return [
                        'success' => false,
                        'status' => 'unknown',
                        'payment_id' => $paymentId,
                        'message' => $statusResult['message'] ?? 'Échec de vérification du statut'
                    ];
                }
            }
            
            // Si aucun tx_ref n'est fourni, c'est une erreur
            return [
                'success' => false,
                'status' => 'unknown',
                'message' => 'Données de retour incomplètes'
            ];
        } catch (Exception $e) {
            Log::error('Erreur Flutterwave handlePaymentReturn: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du retour de paiement',
                'error' => $e->getMessage(),
                'status' => 'error'
            ];
        }
    }
}
