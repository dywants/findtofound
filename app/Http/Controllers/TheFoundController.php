<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Thefind;
use App\Models\Thefound;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TheFoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function register(Thefind $thefind): \Inertia\Response
    {
       return inertia::render('Pieces/TheRegisterInfoFounder', [
           'id' => $thefind->id,
           'fullName' => $thefind->fullName,
           'findCity' => $thefind->findCity,
           'ward' => $thefind->ward,
           'details' => $thefind->details,
           'photos' => $thefind->photos,
           'amount_check' => money($thefind->amount_check),
       ]);
    }

    public function search(): \Inertia\Response
    {
        return inertia::render('Pieces/TheSearch');
    }

    /**
     * @return \Inertia\Response
     */
    public function paiement(): \Inertia\Response
    {
        return inertia::render('Pieces/Paiement');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'city' => 'required|string|max:255',
            'phone_number' => 'bail|required|regex:/^([0-9\s\-\+\(\)]*)$/|max:9',
        ]);

        if (!Auth::check()) {

            $generatedPassword = Str::random(10);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword),
                'role_id' => '1',
            ]);

            Auth::guard()->login($user);
        }else{
            $user = \auth()->user();
            $generatedPassword = $user->password;
        }

        $user->notify(new WelcomeEmailNotification($user,$generatedPassword));

        Thefound::create([
            'user_id' => $user->id,
            'thefind_id' => $request->thefind_id,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
        ]);

        return redirect()->route('paiement')->with([
            'amount_check' => $request->amount_check,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Thefind $theFound
     * @return Response
     */
    public function show(Thefind $theFound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TheFound $theFound
     * @return Response
     */
    public function edit(Thefind $theFound)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Thefind $theFound
     * @return Response
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
}
