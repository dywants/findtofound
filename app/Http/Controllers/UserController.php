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
        $amountByFinder = User::query()
            ->where('id', $user->id)
            ->withSum('finds','amount_check')
            ->get();

        $amountByFinderStatus =  User::query()
            ->where('id', $user->id)
            ->withSum([
                'finds' => fn ($query) => $query->where('approval_status', 1)],
                'amount_check')
            ->get();

        $amountByUser = Thefound::query()
            ->where('user_id', $user->id)
            ->get();

        $thefind = arrat_to_object($amountByFinder);
        $amount_finder = arrat_to_object($amountByFinderStatus);
        $thefound = arrat_to_object($amountByUser);

        if ($user->hasRole('finder')){
            $amount = '';
        }else if($user->hasRole('user')){
            $amount = money($thefound->amount);
        }else{
            $amount = '';
        }

        return Inertia::render('Users/Index', [
            'total_presume_amount' => money($thefind->finds_sum_amount_check),
            'total_amount' => money($amount_finder->finds_sum_amount_check),
            'amount' => $amount
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
            ->get();

        $paymentArray= arrat_to_object($payment);

        $paymentStatus = $paymentArray->payment_status;
        $thefind = arrat_to_object($piece);

        $photos = arrat_to_object(json_decode($thefind->thefind->photos));

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
       return Inertia::render('Users/myPiece', [
           'user' => $user,
           'profile' => $user->profile,
       ]);
    }

    public function profile(): \Inertia\Response
    {
        $userObject = User::where('id', auth()->user()->id)->with('profile')->get();

        $user = arrat_to_object($userObject);

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
            'password' => Hash::make($request->new_pasword)
        ]);

        $request->session()->flash('success', 'Mot de passe motifier avec success');
        return redirect()->back();
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
