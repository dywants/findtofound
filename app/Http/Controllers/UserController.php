<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Piece;
use App\Models\Thefind;
use App\Models\Thefound;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $user = auth()->user();
        
        // Statistiques pour les Finders (Trouveurs)
        if ($user->hasRole('finder')) {
            // Nombre de pièces déclarées
            $declarations = Thefind::where('user_id', $user->id)->count();
            
            // Nombre de pièces en attente
            $pendingDeclarations = Thefind::where('user_id', $user->id)
                ->where('approval_status', 0)
                ->count();
            
            // Nombre de correspondances totales
            $totalMatches = Thefind::where('user_id', $user->id)
                ->whereHas('thefounds')
                ->count();
            
            // Récompenses reçues
            $rewardAmount = User::where('id', $user->id)
                ->withSum([  
                    'finds' => fn ($query) => $query->where('approval_status', 1)],
                    'amount_check')
                ->first();
                
            $rewardsPaid = money($rewardAmount ? $rewardAmount->finds_sum_amount_check : 0);
            
            // Stats à passer à la vue
            $stats = [
                'declarations' => $declarations,
                'pendingDeclarations' => $pendingDeclarations,
                'totalMatches' => $totalMatches,
                'rewardsPaid' => $rewardsPaid
            ];
        } 
        // Statistiques pour les Founders (Propriétaires)
        else {
            // Pièces retrouvées
            $piecesFound = Thefound::where('user_id', $user->id)->count();
            
            // Pièces en attente de retour (n'utilisez pas status qui n'existe pas)
            // Comme il n'y a pas de colonne spécifique pour l'état d'attente, 
            // nous allons simplement compter les correspondances trouvées
            $pendingReturns = Thefound::where('user_id', $user->id)
                ->count();
            
            // Nombre total de recherches effectuées
            $totalSearches = Thefound::where('user_id', $user->id)->count();
            
            // Récompenses versées
            $payments = Payment::where('user_payer_id', $user->id)
                ->where('payment_status', 'completed')
                ->sum('amount');
                
            $rewardsReceived = money($payments);
            
            // Stats à passer à la vue
            $stats = [
                'piecesFound' => $piecesFound,
                'pendingReturns' => $pendingReturns,
                'totalSearches' => $totalSearches,
                'rewardsReceived' => $rewardsReceived
            ];
        }
        
        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'userRole' => $user->hasRole('finder') ? 'finder' : 'founder'
        ]);
    }

    public function listing(): \Inertia\Response
    {
        $user = auth()->user();
    
        $listing = Thefind::query()
            ->when((new \Illuminate\Http\Request)->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->with('piece')
            ->where('user_id', $user->id)
            ->get();

    
        return Inertia::render('Users/TheListingFind', [
            'listing' => $listing,
            "filters" => (new \Illuminate\Http\Request)->only(['search'])
        ]);
    }

    public function myPiece(): \Inertia\Response
    {
        $user = auth()->user();

        $piece = Thefound::query()
            ->where('user_id', $user->id)
            ->with('thefind.user.profile')
            ->with('user.profile')
            ->get();

        $payment = Payment::query()
            ->where('user_payer_id', $user->id)
            ->latest()
            ->first();

        if ($payment) {
            $paymentStatus = $payment->payment_status ?? "";
        } else {
            $paymentStatus = "";
        }

        // Vérification si la collection de pièces est vide
        if ($piece->isEmpty()) {
            // Renvoyer une vue avec des données vides mais valides
            return Inertia::render('Users/MyPiece', [
                'piece' => null,
                'photos' => null,
                'status' => $paymentStatus
            ]);
        }

        $thefind = \App\Helpers\ArrayHelper::toObject($piece);
        
        // Vérification si thefind et ses propriétés existent
        $photos = null;
        if (isset($thefind->thefind) && isset($thefind->thefind->photos)) {
            // Récupérer le premier fichier photo de la liste et en faire une chaîne
            $photosObj = json_decode($thefind->thefind->photos);
            if (is_array($photosObj) && count($photosObj) > 0) {
                $photos = $photosObj[0]->file_name ?? null;
            }
        }

        return Inertia::render('Users/MyPiece', [
            'piece' => $thefind,
            'photos' => $photos,
            'status' => $paymentStatus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function show(User $user): \Inertia\Response
    {
       return Inertia::render('Users/MyPiece', [
           'user' => $user,
           'profile' => $user->profile,
       ]);
    }

    public function profile(): \Inertia\Response
    {
        $userObject = User::where('id', auth()->user()->id)->with('profile')->get();

        $user = \App\Helpers\ArrayHelper::toObject($userObject);

        return Inertia::render('Users/Profile', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update( [
            'name' => $request->name
        ]);

        $profile = $user->profile;
        $profile->update($request->all());

        $request->session()->flash('success', 'User && profile updated successfully');

        return redirect()->back();
    }

    public function updatePassword(Request $request , User $user): RedirectResponse
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if(!Hash::check($request->old_password, $user->password)){
            $request->session()->flash('error', 'Ancien mot de passe ne correspond pas');
            return redirect()->back();
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $request->session()->flash('success', 'Mot de passe motifier avec success');
        return redirect()->back();
    }

    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function updateProfilePhoto(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $user = auth()->user();
            
            // Vérifier si le fichier existe
            if (!$request->hasFile('profile_photo')) {
                return redirect()->back()->with('error', 'Aucun fichier n\'a été téléchargé');
            }
            
            // Récupérer le fichier photo
            $profilePhoto = $request->file('profile_photo');
            
            // Vérifier si le fichier est valide
            if (!$profilePhoto->isValid()) {
                return redirect()->back()->with('error', 'Le fichier uploadé n\'est pas valide');
            }
            
            // Générer un nom de fichier unique
            $filename = time() . '_' . $user->id . '.' . $profilePhoto->getClientOriginalExtension();
            
            // Déplacer le fichier dans le répertoire de stockage public
            $path = $profilePhoto->storeAs('public/profile-photos', $filename);
            
            if (!$path) {
                return redirect()->back()->with('error', 'Erreur lors du stockage du fichier');
            }
            
            // S'assurer que le profil existe
            $profile = $user->profile;
            if (!$profile) {
                return redirect()->back()->with('error', 'Profil utilisateur introuvable');
            }
            
            // Mettre à jour le profil de l'utilisateur avec le chemin de la photo
            $updated = $profile->update([
                'photo_url' => '/storage/profile-photos/' . $filename
            ]);
            
            if (!$updated) {
                return redirect()->back()->with('error', 'Impossible de mettre à jour le profil');
            }
            
            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès');
        } catch (\Exception $e) {
            // Capturer toute exception et renvoyer un message d'erreur
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Update the user's cover photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCoverPhoto(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);
    
            $user = auth()->user();
            
            // Vérifier si le fichier existe
            if (!$request->hasFile('cover_photo')) {
                return redirect()->back()->with('error', 'Aucun fichier n\'a été téléchargé');
            }
            
            // Récupérer le fichier photo
            $coverPhoto = $request->file('cover_photo');
            
            // Vérifier si le fichier est valide
            if (!$coverPhoto->isValid()) {
                return redirect()->back()->with('error', 'Le fichier uploadé n\'est pas valide');
            }
            
            // Générer un nom de fichier unique
            $filename = 'cover_' . time() . '_' . $user->id . '.' . $coverPhoto->getClientOriginalExtension();
            
            // Déplacer le fichier dans le répertoire de stockage public
            $path = $coverPhoto->storeAs('public/cover-photos', $filename);
            
            if (!$path) {
                return redirect()->back()->with('error', 'Erreur lors du stockage du fichier');
            }
            
            // S'assurer que le profil existe
            $profile = $user->profile;
            if (!$profile) {
                return redirect()->back()->with('error', 'Profil utilisateur introuvable');
            }
            
            // Mettre à jour le profil de l'utilisateur avec le chemin de la photo de couverture
            $updated = $profile->update([
                'cover_photo_url' => '/storage/cover-photos/' . $filename
            ]);
            
            if (!$updated) {
                return redirect()->back()->with('error', 'Impossible de mettre à jour le profil');
            }
            
            return redirect()->back()->with('success', 'Photo de couverture mise à jour avec succès');
        } catch (\Exception $e) {
            // Capturer toute exception et renvoyer un message d'erreur
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}