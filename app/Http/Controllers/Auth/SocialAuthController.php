<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirection vers le provider Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Gestion du callback Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $findUser = User::where('google_id', $user->id)
                           ->orWhere('email', $user->email)
                           ->first();
            
            if ($findUser) {
                // Mise à jour si nécessaire
                if (!$findUser->google_id) {
                    $findUser->google_id = $user->id;
                    $findUser->avatar = $user->avatar;
                    $findUser->save();
                }
                
                Auth::login($findUser);
                return redirect()->intended(route('dashboard'));
            } else {
                // Créer un nouvel utilisateur
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire sécurisé
                ]);
                
                // Assigner le rôle par défaut
                $newUser->assignRole('user');
                
                Auth::login($newUser);
                return redirect()->intended(route('dashboard'));
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                             ->with('error', 'Une erreur est survenue lors de l\'authentification Google : ' . $e->getMessage());
        }
    }

    /**
     * Redirection vers le provider Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Gestion du callback Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            
            $findUser = User::where('facebook_id', $user->id)
                           ->orWhere('email', $user->email)
                           ->first();
            
            if ($findUser) {
                // Mise à jour si nécessaire
                if (!$findUser->facebook_id) {
                    $findUser->facebook_id = $user->id;
                    if (!$findUser->avatar) {
                        $findUser->avatar = $user->avatar;
                    }
                    $findUser->save();
                }
                
                Auth::login($findUser);
                return redirect()->intended(route('dashboard'));
            } else {
                // Créer un nouvel utilisateur
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'avatar' => $user->avatar,
                    'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire sécurisé
                ]);
                
                // Assigner le rôle par défaut
                $newUser->assignRole('user');
                
                Auth::login($newUser);
                return redirect()->intended(route('dashboard'));
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                             ->with('error', 'Une erreur est survenue lors de l\'authentification Facebook : ' . $e->getMessage());
        }
    }
}
