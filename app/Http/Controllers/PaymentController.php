<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Thefound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Créer un nouveau paiement
     */
    public function store(Request $request)
    {
        $request->validate([
            'thefound_id' => 'required|exists:thefounds,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:XAF,EUR',
            'payment_source' => 'required|string|in:paypal,mobile_money',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::create([
                'user_payer_id' => auth()->id(),
                'thefind_id' => $request->thefound_id,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_source' => $request->payment_source,
                'payment_status' => 'pending',
                'order_id' => uniqid('PAY-'),
            ]);

            // Mettre à jour le statut dans Thefound
            Thefound::where('id', $request->thefound_id)
                ->update(['payment_status' => 'pending']);

            DB::commit();

            return response()->json([
                'success' => true,
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création paiement : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du paiement'
            ], 500);
        }
    }

    /**
     * Mettre à jour le statut d'un paiement
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,failed',
            'transaction_id' => 'required_if:status,paid|string',
            'payment_details' => 'sometimes|array'
        ]);

        try {
            DB::beginTransaction();

            $payment->update([
                'payment_status' => $request->status,
                'transaction_id' => $request->transaction_id,
                'payment_details' => $request->payment_details,
                'paid_at' => $request->status === 'paid' ? now() : null
            ]);

            // Mettre à jour le statut dans Thefound
            if ($request->status === 'paid') {
                Thefound::where('id', $payment->thefind_id)
                    ->update([
                        'payment_status' => 'paid',
                        'payment_id' => $request->transaction_id,
                        'paid_at' => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur mise à jour paiement : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du paiement'
            ], 500);
        }
    }

    /**
     * Récupérer l'historique des paiements d'un utilisateur
     */
    public function history()
    {
        $payments = Payment::with(['thefind'])
            ->where('user_payer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json($payments);
    }
}
