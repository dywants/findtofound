<?php

namespace App\Http\Middleware;

use App\Models\Thefind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request)
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'appName' => config('app.name', 'Laravel'),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'is_admin' => $request->user() && $request->user()->hasRole('admin'),
            'is_user' => $request->user() && $request->user()->hasRole('user'),
            'is_finder' => $request->user() && $request->user()->hasRole('finder'),
            'searchItems' => function () {
                return Thefind::where('approval_status', 0)
                    ->cursor()
                    ->map(function ($thefind) {
                        return [
                            'fullName' => $thefind->fullName,
                            'amount_check' => money(order_amount($thefind->amount_check)),
                            'amount_piece' => money(amount_piece($thefind->piece_id)),
                            'findCity' => $thefind->findCity,
                            'photos' => decode_image($thefind->photos),
                            'details' => $thefind->details,
                            'created_at' => $thefind->created_at->diffForHumans(),
                            'link' => route('find.show', ['thefind' => $thefind->id]),
                        ];
                    })->toArray();
            },
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error')
            ]
        ]);
    }
}
