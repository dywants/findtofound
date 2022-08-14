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
        $thefound =  Thefound::query()
            ->with('thefind.piece')
            ->where('user_id', $user->id)
            ->with('user.profile')
            ->get();

        $thefoundCollect = arrat_to_object($thefound);

        $afrikpay_payment = new AfrikPayPayment(env('AFRIKPAY_MERCHANTID'), env('AFRIKPAY_CLIENT_SECRET'),false);

        $afrikpay_payment->handle($request, $thefoundCollect, $provider);

        $request->session()->flash('success', 'Super! votre paiement à bien été effectué avec succès');

        return redirect()->route('dashboard');
    }
}
