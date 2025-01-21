<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Thefound;
use App\Services\PaypalPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaypalController extends Controller
{
    protected $paypalService;

    public function __construct()
    {
        $this->paypalService = new PaypalPayment(
            env('PAYPAL_CLIENT_ID'),
            env('PAYPAL_CLIENT_SECRET'),
            env('PAYPAL_MODE', 'sandbox') === 'live'
        );
    }

    public function index(Request $request)
    {
        return Inertia::render('Pieces/Paiement', [
            'clientId' => env('PAYPAL_CLIENT_ID'),
            'currency' => env('PAYPAL_CURRENCY', 'EUR'),
            'mode' => env('PAYPAL_MODE', 'sandbox'),
        ]);
    }

    public function createOrder(Request $request)
    {
        try {
            $thefound = Thefound::findOrFail($request->thefound_id);
            
            // Créer le paiement dans la base de données
            $payment = Payment::create([
                'user_payer_id' => auth()->id(),
                'thefind_id' => $thefound->id,
                'amount' => $thefound->amount,
                'currency' => 'EUR',
                'payment_source' => 'paypal',
                'payment_status' => 'pending',
                'order_id' => uniqid('PAY-'),
            ]);

            // Créer l'ordre PayPal
            $response = $this->paypalService->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => $payment->order_id,
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => number_format($thefound->amount / 655.957, 2, '.', '')
                    ]
                ]]
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Erreur création ordre PayPal : ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function captureOrder(Request $request)
    {
        try {
            $orderId = $request->input('orderID');
            $response = $this->paypalService->captureOrder($orderId);

            if ($response['status'] === 'COMPLETED') {
                $payment = Payment::where('order_id', $response['purchase_units'][0]['reference_id'])->first();
                
                if ($payment) {
                    $payment->update([
                        'payment_status' => 'paid',
                        'transaction_id' => $response['id'],
                        'payment_details' => $response,
                        'paid_at' => now()
                    ]);

                    // Mettre à jour le Thefound
                    Thefound::where('id', $payment->thefind_id)->update([
                        'payment_status' => 'paid',
                        'payment_id' => $response['id'],
                        'paid_at' => now()
                    ]);
                }
            }

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Erreur capture PayPal : ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
