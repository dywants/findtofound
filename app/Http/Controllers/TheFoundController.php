<?php

namespace App\Http\Controllers;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Contracts\Meta;
use App\Models\Profile;
use App\Models\Thefind;
use App\Models\Thefound;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use App\Services\PaypalPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TheFoundController extends Controller
{
    /**
     * Afficher le formulaire d'inscription pour une annonce trouvée
     */
    public function register(Thefind $thefind): \Inertia\Response
    {
        Meta::addMeta('title', 'Chercher sa pièce!');
        Meta::addMeta('description', "Cette page permet de faire une recherche de sa pièce dans notre base de données");
        Meta::addMeta('robots', 'Index, follow');

        $existingThefound = null;
        $userInfo = [];
        
        if (Auth::check()) {
            $existingThefound = Thefound::where('user_id', Auth::id())
                ->where('thefind_id', $thefind->id)
                ->first();
                
            $user = Auth::user();
            $profile = $user->profile;
            
            $userInfo = [
                'email' => $user->email,
                'phone_number' => $profile->phone_number ?? '',
                'city' => $profile->city ?? '',
            ];
        }

        $amount = $this->calculateAmount($thefind);

       
        $amountEUR = $this->convertToEUR($amount);

        return Inertia::render('Pieces/TheRegisterInfoFounder', [
            'id' => $thefind->id,
            'fullName' => $thefind->fullName,
            'findCity' => $thefind->findCity,
            'ward' => $thefind->ward,
            'details' => $thefind->details,
            'photos' => $thefind->photos,
            'amount' => $amount,
            'amount_formatted' => money($amount),
            'amount_eur' => $amountEUR,
            'amount_eur_formatted' => number_format($amountEUR, 2) . ' EUR',
            'type_piece' => $thefind->piece->name ?? '',
            'hasExistingRegistration' => !is_null($existingThefound),
            'userInfo' => $userInfo
        ]);
    }

    /**
     * Calculer le montant total (frais de service + montant de la pièce)
     */
    private function calculateAmount(Thefind $thefind): float
    {
        // Récupérer le montant de base pour ce type de pièce
        $pieceAmount = amount_piece($thefind->piece_id);
        
        // Récupérer le montant de récompense spécifié
        $serviceAmount = order_amount($thefind->amount_check);
        
        // Le montant total est la somme des frais spécifiques à la pièce et de la récompense
        return $serviceAmount + $pieceAmount;
    }

    /**
     * Convertir le montant en EUR
     */
    private function convertToEUR(float $amount): float
    {
        // Taux de conversion fixe XAF vers EUR (1 EUR = 655.957 XAF)
        $rate = 655.957;
        return round($amount / $rate, 2);
    }

    /**
     * Enregistrer un nouveau founder
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:9',
            'thefind_id' => 'required|exists:thefinds,id',
        ]);

        try {
            DB::beginTransaction();

            // Vérifier si l'enregistrement existe déjà
            if (Auth::check()) {
                $existingThefound = Thefound::where('user_id', Auth::id())
                    ->where('thefind_id', $request->thefind_id)
                    ->first();

                if ($existingThefound) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Vous pouvez maintenant procéder au paiement.');
                }
            }

            // Créer ou récupérer l'utilisateur
            if (!Auth::check()) {
                $generatedPassword = Str::random(10);
                
                // Créer l'utilisateur
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($generatedPassword),
                ]);

                // Assigner le rôle
                $user->assignRole('User');

                // Connecter l'utilisateur directement avec ses identifiants
                Auth::attempt([
                    'email' => $request->email,
                    'password' => $generatedPassword
                ]);

                // Envoyer l'email avec les identifiants
                $user->notify(new WelcomeEmailNotification($user, $generatedPassword));

                // Régénérer la session pour la sécurité
                $request->session()->regenerate();
            } else {
                $user = auth()->user();
            }

            // Récupérer l'annonce
            $thefind = Thefind::findOrFail($request->thefind_id);
            $amount = $this->calculateAmount($thefind);

            // Créer l'enregistrement Thefound
            Thefound::create([
                'user_id' => $user->id,
                'thefind_id' => $thefind->id,
                'amount' => $amount,
                'payment_status' => 'pending'
            ]);

            // Créer ou mettre à jour le profil
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $request->phone_number,
                    'city' => $request->city,
                ]
            );

            DB::commit();

            return redirect()->back()->with('success', 'Vos informations ont été enregistrées avec succès. Vous pouvez maintenant procéder au paiement.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.');
        }
    }

    public function search(): \Inertia\Response
    {
        // Récupérer tous les éléments à rechercher, sans filtrer par approval_status
        $allItems = \App\Models\Thefind::select('id', 'fullName', 'findCity', 'details', 'created_at', 'photos')
            ->orderBy('created_at', 'desc') // Trier par date de création, plus récent en premier
            ->get();

        // Journaliser les résultats bruts
        $logContent = "Nombre total d'éléments trouvés: " . $allItems->count() . "\n";
        $logContent .= "Recherche de 'Lael Tanner': " . \App\Models\Thefind::where('fullName', 'like', '%Lael Tanner%')->count() . "\n";
        
        // Formater les données pour la recherche
        $searchItems = $allItems->map(function($item) {
            // S'assurer que le champ photos est correctement traité
            $photos = [];
            if ($item->photos) {
                // Gérer différents formats potentiels de photos
                if (is_string($item->photos)) {
                    // Si c'est une chaîne JSON doublement encodée
                    if (substr($item->photos, 0, 1) == '"' && substr($item->photos, -1) == '"') {
                        // Supprimer les guillemets externes
                        $cleanJson = trim($item->photos, '"');
                        // Remplacer les barres obliques échappées
                        $cleanJson = str_replace('\\', '\\', $cleanJson);
                        try {
                            $photos = json_decode($cleanJson, true) ?: [];
                        } catch (\Exception $e) {
                            $photos = [];
                        }
                    } else {
                        try {
                            $photos = json_decode($item->photos, true) ?: [];
                        } catch (\Exception $e) {
                            $photos = [];
                        }
                    }
                } elseif (is_array($item->photos)) {
                    $photos = $item->photos;
                }
            }
            
            // Créer des valeurs par défaut pour amount_check et amount_piece
            $defaultAmount = [
                'amount' => 0,
                'formatted' => 'N/A'
            ];
            
            return [
                'id' => $item->id,
                'fullName' => $item->fullName,
                'findCity' => $item->findCity,
                'details' => $item->details ?: '',  // Éviter les valeurs NULL
                'date' => $item->created_at->format('Y-m-d'),
                'created_at' => $item->created_at->format('Y-m-d'), // Pour le formatage des dates
                'photos' => $photos, 
                'link' => route('find.show', $item->id),
                'amount_check' => $defaultAmount,
                'amount_piece' => $defaultAmount
            ];
        });
        
        // Ajouter un élément factice pour s'assurer que le système fonctionne
        $searchItems->push([
            'id' => 9999,
            'fullName' => 'Objet Test',
            'findCity' => 'Ville de Test',
            'details' => 'Cet objet est ajouté pour tester la recherche',
            'date' => date('Y-m-d'),
            'created_at' => date('Y-m-d'),
            'photos' => ['test.jpg'],
            'link' => route('find.show', 1),
            'amount_check' => [
                'amount' => 0,
                'formatted' => '0 F CFA'
            ],
            'amount_piece' => [
                'amount' => 500,
                'formatted' => '500 F CFA'
            ]
        ]);
        
        // Journaliser les données transformées
        $logContent .= "Données transformées pour la recherche:\n";
        $logContent .= "Nombre d'éléments après transformation: " . $searchItems->count() . "\n";
        if ($searchItems->count() > 0) {
            $logContent .= "Premier élément: " . json_encode($searchItems->first(), JSON_PRETTY_PRINT) . "\n";
        }
        
        // Écrire dans un fichier de log dédié
        file_put_contents(storage_path('logs/search_debug.log'), $logContent, FILE_APPEND);
        
        // Vérifier qu'on a des données
        if ($searchItems->isEmpty()) {
            $logContent .= "ERREUR: Aucune donnée n'a été préparée pour la recherche!\n";
            file_put_contents(storage_path('logs/search_debug.log'), $logContent, FILE_APPEND);
        }
        
        // Convertir la collection en tableau pour éviter les problèmes de sérialisation
        $searchItemsArray = $searchItems->toArray();
        
        // Journaliser le résultat final
        $logContent .= "Données envoyées à la vue: " . count($searchItemsArray) . " éléments\n";
        file_put_contents(storage_path('logs/search_debug.log'), $logContent, FILE_APPEND);
            
        return inertia::render('Pieces/TheSearch', [
            'searchItems' => $searchItemsArray
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Thefind $theFound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thefind $theFound
     * @return Response
     */
    public function destroy(Thefind $theFound)
    {
        //
    }

    public function multipleexplode ($delimiters,$string): array
    {
        $phase = str_replace($delimiters, $delimiters[0], $string);
        return explode($delimiters[0], $phase);
    }
}