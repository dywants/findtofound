<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindRequest;
use App\Models\Piece;
use App\Models\Profile;
use App\Models\Thefind;
use App\Models\User;
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
    public function index()
    {
        $pieces = Piece::all();

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
        if (!Auth::check()) {

            $generatedPassword = Str::random(10);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword),
                'role_id' => '2',
            ]);

            Auth::guard()->login($user);
        }else{
            $user = \auth()->user();
            $generatedPassword = $user->password;
        }

        if ($request->hasFile('photos')){
            $arrayImage = $request->photos;

            function arrat_to_object($arrayImage)
            {
                $photoObj = "";
                foreach($arrayImage as $image){
                    $photoObj = $image;
                }

                return $photoObj;
            }

            $imageObject = arrat_to_object($arrayImage);
            $imageName = time(). '.' . $user->id . now()->format('y') . '/' . now()->format('m') . $imageObject->extension();
            $imageObject->storeAs('findImages', $imageName);
        }

        Thefind::create([
            'fullName' => $request->fullName,
            'findCity' => $request->findCity,
            'ward' => $request->ward,
            'details' => $request->details,
            'amount_check' => $request->amount_check,
            'photos' => $imageName,
            'user_id' => $user->id,
            'piece_id' => $request->piece_id,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
        ]);

       return redirect(RouteServiceProvider::HOME)->with([
            'password' => $generatedPassword
        ]);
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
            'thefind' => $thefind
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
     * @return Response
     */
    public function update(Request $request, Thefind $thefind)
    {
        //
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