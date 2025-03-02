<?php

namespace App\Http\Controllers;

use App\Contracts\Meta;
use App\Http\Requests\FindRequest;
use App\Mail\UserPasswordMail;
use App\Models\Piece;
use App\Models\Profile;
use App\Models\Thefind;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use stdClass;

class TheFindController extends Controller
{
    /**
     * Display the introduction page for the registration process.
     *
     * @return \Inertia\Response
     */
    public function intro(): \Inertia\Response
    {
        Meta::addMeta('title', 'Introduction à l\'enregistrement d\'objet trouvé');
        Meta::addMeta('description', "Découvrez le processus d'enregistrement d'un objet trouvé et vos options concernant les récompenses.");
        Meta::addMeta('robots', 'Index, follow');

        return inertia::render('Pieces/RegisterIntro');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        $pieces = Piece::all();
        Meta::addMeta('title', 'Enregistrer une pièce retrouvée!');
        Meta::addMeta('description', "Cette page permet l'enregistrement des informations d'une pièce retrouvée ainsi que les informations de celui qui à retrouvée la pièce");
        Meta::addMeta('robots', 'Index, follow');

        // Récupérer la préférence de récompense depuis la requête
        $wantReward = $request->has('wantReward') ? filter_var($request->wantReward, FILTER_VALIDATE_BOOLEAN) : true;

        return inertia::render('Pieces/TheRegister', [
            'pieces' => $pieces,
            'wantReward' => $wantReward,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FindRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(FindRequest $request): Application|RedirectResponse|Redirector
    {
        $imgData = [];
        
        if ($request->hasFile('photos')) {
            $arrayImage = $request->photos;
            foreach ($arrayImage as $file) {
                $imageName = time() . '.' . now()->format('y') . '/' . now()->format('m') . $file->getClientOriginalName();
                $file->storeAs('findImages', $imageName);
                $imgData[] = $imageName;
            }
        }

        // Préparer les données de base pour Thefind
        $findData = [
            'fullName' => $request->fullName,
            'findCity' => $request->findCity,
            'ward' => $request->ward,
            'details' => $request->details,
            'amount_check' => $request->amount_check,
            'photos' => json_encode($imgData),
            'piece_id' => $request->piece_id,
            'discovery_date' => $request->discovery_date,
            'piece_condition' => $request->piece_condition,
            'condition_details' => $request->condition_details,
            'special_instructions' => $request->special_instructions
        ];

        // Déterminer si l'utilisateur veut une récompense (par défaut: oui)
        $wantReward = $request->has('wantReward') ? filter_var($request->wantReward, FILTER_VALIDATE_BOOLEAN) : true;
        
        // Ajouter le champ want_reward aux données
        $findData['want_reward'] = $wantReward;
        
        // Scénario 1: L'utilisateur NE VEUT PAS de récompense
        if (!$wantReward) {
            // Traiter les données de dépôt
            $findData['is_anonymous'] = true; // Considéré comme anonyme pour la base de données
            $findData['localisation'] = $request->localisation;
            $findData['deposit_location'] = $request->localisation;
            $findData['pickup_hours'] = $request->pickup_hours;
            $findData['special_instructions'] = $request->additionalInfo ?? null;
            
            // Ajouter la date de dépôt avec le bon format
            if ($request->depositDate) {
                $findData['deposit_date'] = $request->depositDate;
            }
        }
        // Scénario 2: L'utilisateur VEUT une récompense
        else {
            $findData['is_anonymous'] = $request->checkAnnonymary;
            
            // Scénario 2A: Utilisateur anonyme avec récompense
            if ($request->checkAnnonymary) {
                $findData['localisation'] = $request->localisation;
                $findData['deposit_location'] = $request->deposit_location ?? $request->localisation;
                $findData['deposit_city'] = $request->deposit_city;
                $findData['deposit_district'] = $request->deposit_district;
                $findData['contact_person'] = $request->contact_person;
                $findData['pickup_hours'] = $request->pickup_hours;
            }
            // Scénario 2B: Utilisateur identifié avec récompense
            else {
                // Gérer l'utilisateur
                if (!Auth::check()) {
                    $generatedPassword = Str::random(10);
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($generatedPassword),
                    ]);
                    // Envoyer le mot de passe par email
                    Mail::to($user->email)->send(new UserPasswordMail($user, $generatedPassword));
                    
                    Auth::guard()->login($user);
                    $user->assignRole('Founds');
                } else {
                    $user = auth()->user();
                    $generatedPassword = null;
                }

                // Ajouter user_id seulement pour les soumissions non-anonymes
                $findData['user_id'] = $user->id;

                // Créer ou mettre à jour le profil
                Profile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone_number' => $request->phone_number,
                        'city' => $request->city,
                    ]
                );
            }
        }

        // Créer l'enregistrement Thefind
        Thefind::create($findData);

        // Préparer le message de retour
        if (!$wantReward) {
            $message = 'Merci pour votre déclaration! Les informations de dépôt ont été enregistrées.';
        } else if ($request->checkAnnonymary) {
            $message = 'Merci pour votre contribution anonyme!';
        } else {
            $message = isset($generatedPassword) 
                ? "Votre compte a été créé avec succès! Votre mot de passe temporaire est: $generatedPassword" 
                : "Merci pour votre contribution!";
        }

        return redirect('/')->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return \Inertia\Response
     */
    public function show(Thefind $thefind): \Inertia\Response
    {
        return inertia::render('Pieces/TheShowFind', [
            'id' => $thefind->id,
            'fullName' => $thefind->fullName,
            'findCity' => $thefind->findCity,
            'ward' => $thefind->ward,
            'details' => $thefind->details,
            'photos' => json_decode($thefind->photos),
            'amount_check' => money(order_amount($thefind->amount_check)),
            'amount_piece' => money(amount_piece($thefind->piece_id))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return Response
     */
    public function edit(Thefind $thefind)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thefind  $thefind
     * @return RedirectResponse
     */
    public function update(Request $request, Thefind $thefind): RedirectResponse
    {
        $thefind->update([
            'approval_status' => 1
        ]);

        $request->session()->flash('success', 'Félicitation, vous avez retrouver votre pièce perdue!');

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thefind  $thefind
     * @return Response
     */
    public function destroy(Thefind $thefind)
    {
        //
    }
}
