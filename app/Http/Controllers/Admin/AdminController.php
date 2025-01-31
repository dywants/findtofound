<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Thefind;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
   public function index(): \Inertia\Response
   {
       $SumPaypalPayment = Payment::where('payment_source', 'paypal')->sum('amount');
       $SumOrangePayment = Payment::where('payment_source', 'orange')->sum('amount');
       $SumMtnPayment = Payment::where('payment_source', 'mtn')->sum('amount');
       $totalCNI = Thefind::count();

       // Récupérer les clients récents (utilisateurs)
       $recentClients = User::with('profile')
           ->latest()
           ->take(10)
           ->get()
           ->map(function ($user) {
               return [
                   'id' => $user->id,
                   'name' => $user->name,
                   'email' => $user->email,
                   'company' => $user->profile?->company ?? 'N/A',
                   'city' => $user->profile?->city ?? 'N/A',
                   'progress' => rand(0, 100), // À remplacer par une vraie métrique si disponible
                   'avatar' => $user->profile?->avatar ?? 'https://avatars.dicebear.com/v2/initials/' . $user->name . '.svg',
                   'created_at' => $user->created_at->format('M d, Y')
               ];
           });

       return Inertia::render('Admin/Index', [
           'paypalPayment' => $SumPaypalPayment,
           'orangePayment' => $SumOrangePayment,
           'mtnPayment' => $SumMtnPayment,
           'totalCNI' => $totalCNI,
           'clients' => $recentClients
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

    public function show($id): \Inertia\Response
    {
        $find = Thefind::with(['piece', 'user.profile'])
            ->findOrFail($id);

        return Inertia::render('Admin/Find/Show', [
            'find' => $find
        ]);
    }

    public function edit($id): \Inertia\Response
    {
        $find = Thefind::with(['piece', 'user.profile'])
            ->findOrFail($id);

        return Inertia::render('Admin/Find/Edit', [
            'find' => $find
        ]);
    }

    public function update(Request $request, $id)
    {
        $find = Thefind::findOrFail($id);
        
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'findCity' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'approval_status' => 'required|boolean',
            'amount_check' => 'required|numeric'
        ]);

        $find->update($validated);

        return redirect()->route('admin.allFind')
            ->with('success', 'Pièce mise à jour avec succès');
    }

    public function destroy($id)
    {
        $find = Thefind::findOrFail($id);
        $find->delete();

        return redirect()->route('admin.allFind')
            ->with('success', 'Pièce supprimée avec succès');
    }
}