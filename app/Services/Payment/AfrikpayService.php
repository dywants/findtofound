<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class AfrikpayService implements PaymentServiceInterface
{
    /**
     * L'URL de base de l'API Afrikpay
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Clé API pour l'authentification
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Clé secrète pour l'authentification
     *
     * @var string
     */
    protected $secretKey;

    /**
     * ID du marchand
     *
     * @var string
     */
    protected $merchantId;

    /**
     * Constructeur du service Afrikpay
     */
    public function __construct()
    {
        $this->baseUrl = config('payment.afrikpay.sandbox') 
            ? 'https://sandbox.afrikpay.com/api' 
            : 'https://api.afrikpay.com';
        
        $this->apiKey = config('payment.afrikpay.api_key');
        $this->secretKey = config('payment.afrikpay.secret_key');
        $this->merchantId = config('payment.afrikpay.merchant_id');
    }

    /**
     * Générer la signature pour sécuriser les requêtes
     *
     * @param array $data Les données à signer
     * @return string La signature
     */
    protected function generateSignature(array $data): string
    {
        // Trier les données par clé pour garantir une signature cohérente
        ksort($data);
        
        // Concaténation des données
        $stringToSign = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                continue; // Ignorer les tableaux imbriqués
            }
            $stringToSign .= $key . '=' . $value . '&';
        }
        
        // Ajouter la clé secrète
        $stringToSign .= $this->secretKey;
        
        // Retourner la signature en SHA256
        return hash('sha256', $stringToSign);
    }

    /**
     * Initialiser un paiement avec Afrikpay
     *
     * @param array $paymentData Données nécessaires pour initier le paiement
     * @return array Tableau contenant les informations de redirection
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            // Générer un ID de transaction unique
            $transactionId = 'FTOF_' . time() . '_' . $paymentData['plan_id'] . '_' . $paymentData['user_id'];
            
            // Préparer les données pour la requête
            $requestData = [
                'merchant_id' => $this->merchantId,
                'transaction_id' => $transactionId,
                'amount' => number_format($paymentData['amount'], 2, '.', ''),
                'currency' => $paymentData['currency'],
                'description' => 'Abonnement plan: ' . ($paymentData['plan_name'] ?? 'Plan premium'),
                'return_url' => route('afrikpay.return'),
                'cancel_url' => route('afrikpay.cancel'),
                'notify_url' => route('afrikpay.webhook'),
                'customer_email' => $paymentData['billing_info']['email'] ?? '',
                'customer_phone' => $paymentData['billing_info']['phone'] ?? '',
                'customer_name' => ($paymentData['billing_info']['firstName'] ?? '') . ' ' . ($paymentData['billing_info']['lastName'] ?? ''),
                'api_key' => $this->apiKey,
                'timestamp' => time()
            ];
            
            // Générer la signature
            $requestData['signature'] = $this->generateSignature($requestData);
            
            // Envoyer la requête à Afrikpay
            $response = Http::post("$this->baseUrl/payment/init", $requestData);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Vérifier si l'initialisation a réussi
                if ($data['status'] === 'success') {
                    // TODO: Enregistrer les détails de transaction dans la base de données
                    
                    return [
                        'success' => true,
                        'payment_id' => $data['payment_id'] ?? $transactionId,
                        'redirect_url' => $data['payment_url'],
                        'status' => 'pending',
                        'provider' => 'afrikpay'
                    ];
                } else {
                    Log::error('Échec d\'initialisation Afrikpay: ' . json_encode($data));
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Échec d\'initialisation du paiement',
                        'error' => $data
                    ];
                }
            }
            
            Log::error('Échec de réponse Afrikpay: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de communication avec Afrikpay',
                'error' => $response->json() ?? $response->body()
            ];
        } catch (Exception $e) {
            Log::error('Erreur Afrikpay initiatePayment: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation du paiement Afrikpay',
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
            // Préparer les données pour la requête
            $requestData = [
                'merchant_id' => $this->merchantId,
                'payment_id' => $paymentId,
                'api_key' => $this->apiKey,
                'timestamp' => time()
            ];
            
            // Générer la signature
            $requestData['signature'] = $this->generateSignature($requestData);
            
            // Envoyer la requête à Afrikpay
            $response = Http::post("$this->baseUrl/payment/status", $requestData);
            
            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'status' => $data['status'] ?? 'unknown',
                    'data' => $data
                ];
            }
            
            Log::error('Échec de vérification du statut Afrikpay: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Échec de vérification du statut du paiement',
                'error' => $response->json() ?? $response->body()
            ];
        } catch (Exception $e) {
            Log::error('Erreur Afrikpay checkPaymentStatus: ' . $e->getMessage());
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
        try {
            // Valider la signature pour les webhooks
            if (isset($data['signature'])) {
                $receivedSignature = $data['signature'];
                unset($data['signature']);
                
                $calculatedSignature = $this->generateSignature($data);
                
                if ($receivedSignature !== $calculatedSignature) {
                    Log::error('Signature Afrikpay invalide');
                    return [
                        'success' => false,
                        'message' => 'Signature invalide',
                        'status' => 'invalid'
                    ];
                }
            }
            
            // Traiter selon le statut du paiement
            $paymentStatus = $data['status'] ?? 'unknown';
            $paymentId = $data['payment_id'] ?? ($data['transaction_id'] ?? null);
            
            switch ($paymentStatus) {
                case 'success':
                case 'completed':
                    // Paiement réussi
                    // TODO: Mettre à jour le statut de l'abonnement en base de données
                    
                    return [
                        'success' => true,
                        'status' => 'completed',
                        'payment_id' => $paymentId
                    ];
                    
                case 'failed':
                case 'declined':
                case 'cancelled':
                    // Échec de paiement
                    
                    return [
                        'success' => false,
                        'status' => $paymentStatus,
                        'payment_id' => $paymentId,
                        'message' => $data['message'] ?? 'Paiement échoué'
                    ];
                    
                case 'pending':
                    // Paiement en attente
                    
                    return [
                        'success' => true,
                        'status' => 'pending',
                        'payment_id' => $paymentId,
                        'message' => 'Paiement en attente de traitement'
                    ];
                    
                default:
                    // Statut inconnu
                    
                    return [
                        'success' => false,
                        'status' => 'unknown',
                        'payment_id' => $paymentId,
                        'message' => 'Statut de paiement inconnu: ' . $paymentStatus
                    ];
            }
        } catch (Exception $e) {
            Log::error('Erreur Afrikpay handlePaymentReturn: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erreur lors du traitement du retour de paiement',
                'error' => $e->getMessage(),
                'status' => 'error'
            ];
        }
    }
}
