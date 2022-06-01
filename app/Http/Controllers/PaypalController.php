<?php

namespace App\Http\Controllers;

use App\Models\Thefound;
use App\Services\PaypalPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Psr\Http\Message\ServerRequestInterface;

class PaypalController extends Controller
{
    public function index(Request $request) {
        $payment = new PaypalPayment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'),true);
        return Inertia::render('Pieces/Paiement', [
            'paiement' => $payment
        ]);
    }

    public function store (ServerRequestInterface $request, Thefound $thefound) {
        $payment = new PaypalPayment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'),true);
        $payment->handle($request, $thefound);
    }
}
