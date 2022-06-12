<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Thefind;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
   public function index(): \Inertia\Response
   {
       $SumPaypalPayment = Payment::where('paymentSource', 'paypal')->sum('amount');
       $SumOrangePayment = Payment::where('paymentSource', 'orange')->sum('amount');
       $SumMtnPayment = Payment::where('paymentSource', 'mtn')->sum('amount');

       return Inertia::render('Admin/Index', [
           'paypalPayment' => $SumPaypalPayment,
           'orangePayment' => $SumOrangePayment,
           'mtnPayment' => $SumMtnPayment,
       ]);
   }

   public function users(): \Inertia\Response
   {
       $users = User::latest()->with('role')->get();
       return Inertia::render('Admin/Users/Index', [
           'users' => $users
       ]);
   }

   public function create(): \Inertia\Response
   {
       return Inertia::render('Admin/Users/Create');
   }

    public function listingPayment(): \Inertia\Response
    {
        $payments = Payment::latest()
            ->with('userPayer')
            ->with('thefind.piece')
            ->get();

        return Inertia::render('Admin/Payment', [
            'payments' => $payments
        ]);
    }

    public function finderPayment(): \Inertia\Response
    {
        $payments = Payment::latest()
            ->with('thefind')
            ->with('thefind.user.profile')
            ->get();

        return Inertia::render('Admin/Users/Payment', [
            'payments' => $payments
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function allFind(): \Inertia\Response
    {
        $finds = Thefind::latest()->with('piece')
            ->with('user')
            ->get();

        return Inertia::render('Admin/Find', [
            'finds' => $finds,
        ]);
    }

}
