<?php

namespace App\Http\Controllers;

use App\Models\Thefind;
use App\Models\Thefound;
use App\Models\User;
use Illuminate\Http\Request;
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
        return Inertia::render('Users/Index');
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

        function arrat_to_object($piece)
        {
            $elem = "";
            foreach($piece as $item){
                $elem = $item;
            }

            return $elem;
        }

        $thefind = arrat_to_object($piece);

        return Inertia::render('Users/MyPiece', [
            'piece' => $thefind
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
       return Inertia::render('Users/myPiece', [
           'user' => $user,
           'profile' => $user->profile,
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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
