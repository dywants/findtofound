<?php

namespace App\Http\Controllers;

use App\Contracts\Meta;
use App\Http\Requests\FindRequest;
use App\Models\Piece;
use App\Models\Profile;
use App\Models\Thefind;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
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
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $pieces = Piece::all();
        Meta::addMeta('title', 'Enregistrer une pièce retrouvée!');
        Meta::addMeta('description', "Cette page permet l'enregistrement des informations d'une pièce retrouvée ainsi que les informations de celui qui à retrouvée la pièce");
        Meta::addMeta('robots', 'Index, follow');

        return inertia::render('Pieces/TheRegister', [
            'pieces' => $pieces,
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
            'is_anonymous' => $request->checkAnnonymary,
            'discovery_date' => $request->discovery_date,
            'piece_condition' => $request->piece_condition,
            'condition_details' => $request->condition_details,
            'deposit_location' => $request->deposit_location,
            'deposit_city' => $request->deposit_city,
            'deposit_district' => $request->deposit_district,
            'contact_person' => $request->contact_person,
            'pickup_hours' => $request->pickup_hours,
            'special_instructions' => $request->special_instructions
        ];

        // Ajouter la localisation si anonyme
        if ($request->checkAnnonymary) {
            $findData['localisation'] = $request->localisation;
            // Ne pas inclure user_id pour les soumissions anonymes
        } else {
            // Gérer l'utilisateur pour les soumissions non-anonymes
            if (!Auth::check()) {
                $generatedPassword = Str::random(10);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($generatedPassword),
                ]);
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

        // Créer l'enregistrement Thefind
        Thefind::create($findData);

        // Préparer le message de retour
        if ($request->checkAnnonymary) {
            $message = 'Merci pour votre contribution anonyme!';
        } else {
            $message = $generatedPassword 
                ? "Votre compte a été créé avec succès! Votre mot de passe temporaire est: $generatedPassword" 
                : "Merci pour votre contribution!";
        }

        return redirect(RouteServiceProvider::HOME)->with('message', $message);
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
