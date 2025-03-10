<?php

namespace App\Services\Payment;

interface PaymentServiceInterface
{
    /**
     * Initialiser un paiement avec le service
     *
     * @param array $paymentData Données nécessaires pour initier le paiement
     * @return array Tableau contenant les informations de redirection
     */
    public function initiatePayment(array $paymentData): array;
    
    /**
     * Vérifier le statut d'un paiement
     *
     * @param string $paymentId Identifiant du paiement à vérifier
     * @return array Tableau contenant les informations sur le statut du paiement
     */
    public function checkPaymentStatus(string $paymentId): array;
    
    /**
     * Gérer le retour de paiement (webhook ou redirection)
     *
     * @param array $data Données reçues lors du retour de paiement
     * @return array Résultat du traitement
     */
    public function handlePaymentReturn(array $data): array;
}
