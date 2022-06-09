<?php

namespace App\Http\Controllers;

use App\Models\Thefound;
use App\Services\PaypalPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

class PaypalController extends Controller
{
    public function index(Request $request) {
        $payment = new PaypalPayment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'),true);
        return Inertia::render('Pieces/Paiement', [
            'paiement' => $payment
        ]);
    }

    public function store (Request $sessionRequest) {
        $user = auth()->user();
        $thefound =  Thefound::query()
            ->where('user_id', $user->id)
            ->get();

        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

        $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
            $psr17Factory, // ServerRequestFactory
            $psr17Factory, // UriFactory
            $psr17Factory, // UploadedFileFactory
            $psr17Factory  // StreamFactory
        );

        $thefoundCollect = arrat_to_object($thefound);

        $request = $creator->fromGlobals();

        $payment = new PaypalPayment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'),true);
        $payment->handle($request, $thefoundCollect);

        $sessionRequest->session()->flash('success', 'Super! votre paiement à bien été effectué avec succès');

        return redirect()->route('dashboard');
    }
}
