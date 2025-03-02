<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }
    
    /**
     * Display the registration view for users who want to receive a reward.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function createForFinder(Request $request)
    {
        // Récupérer l'URL de redirection après inscription et le choix de récompense
        $redirectUrl = $request->query('redirectUrl', route('find.register'));
        $wantReward = filter_var($request->query('wantReward', 'true'), FILTER_VALIDATE_BOOLEAN);
        
        return Inertia::render('Auth/RegisterFinder', [
            'redirectUrl' => $redirectUrl,
            'wantReward' => $wantReward
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    
    /**
     * Handle an incoming registration request for a finder (someone who found an object)
     * and redirect to the registration page with the wantReward parameter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeForFinder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted',
            'redirectUrl' => 'required|string',
            'wantReward' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Attribuer le rôle Founds à l'utilisateur s'il existe dans le système
        if (class_exists('\Spatie\Permission\Models\Role') && \Spatie\Permission\Models\Role::where('name', 'Founds')->exists()) {
            $user->assignRole('Founds');
        }

        event(new Registered($user));

        Auth::login($user);
        
        // Récupérer l'URL de redirection et le paramètre wantReward
        $redirectUrl = $request->redirectUrl;
        $wantReward = $request->wantReward ? 'true' : 'false';
        
        // Construire l'URL avec le paramètre wantReward
        $separator = str_contains($redirectUrl, '?') ? '&' : '?';
        $finalRedirectUrl = "{$redirectUrl}{$separator}wantReward={$wantReward}";
        
        return redirect($finalRedirectUrl);
    }
}
