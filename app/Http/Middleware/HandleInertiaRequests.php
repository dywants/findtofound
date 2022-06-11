<?php

namespace App\Http\Middleware;

use App\Models\Thefind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'is_admin' => $request->user() && $request->user()->hasRole('admin'),
            'is_user' => $request->user() && $request->user()->hasRole('user'),
            'is_finder' => $request->user() && $request->user()->hasRole('finder'),
            'searchItems' => function () {
//                return Cache::rememberForever('searchItems', function () {
                    return Thefind::where('approval_status', 0)
                        ->cursor()
                        ->map(function ($thefind) {
                        return [
                            'fullName' => $thefind->fullName,
                            'amount_check' =>money(order_amount($thefind->amount_check)),
                            'amount_piece' => money(amount_piece($thefind->piece_id)),
                            'findCity' => $thefind->findCity,
//                            'photos' => asset('storage/findImages/'. $thefind->photos),
                            'photos' => decode_image($thefind->photos),
                            'details' => $thefind->details,
                            'created_at' => $thefind->created_at->diffForHumans(),
                            'link' => route('find.show', ['thefind' => $thefind->id]),
                        ];
                    })->toArray();
//                });
            },
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error')
            ]
        ]);
    }
}
