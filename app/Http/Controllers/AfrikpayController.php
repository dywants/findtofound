<?php

namespace App\Http\Controllers;

use App\Models\Thefound;
use App\Services\AfrikPayPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AfrikpayController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $providers = (array)json_decode(config('afrikpay.providers'), true);

        return Inertia::render('Pieces/TheRegisterInfoFounder', [
            'providers' => $providers
        ]);
    }

    /**
     * @param Request $request
     *
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $provider = $request->data;

        $user = auth()->user();
        $thefound = Thefound::query()
            ->with(['thefind.piece', 'user.profile'])
            ->where('user_id', $user->id)
            ->first();  

        if (!$thefound) {
            return redirect()->back()->with('error', 'Aucun enregistrement trouvé.');
        }

        try {
            $afrikpay_payment = new AfrikPayPayment(
                env('AFRIKPAY_ACCOUNT_ID'), 
                env('AFRIKPAY_CLIENT_SECRET'),
                false
            );

            $afrikpay_payment->handle($request, $thefound, $provider);

            return redirect()->route('dashboard')
                ->with('success', 'Super! votre paiement à bien été effectué avec succès');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors du paiement : ' . $e->getMessage());
        }
    }

    public function generateToken(){
        $token = new AfrikPayPayment(env('AFRIKPAY_ACCOUNT_ID'), env('AFRIKPAY_CLIENT_SECRET'),false);
        $token->generateToken();
    }
}
