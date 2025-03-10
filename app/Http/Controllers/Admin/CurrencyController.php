<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\SubscriptionPlan;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderBy('is_default', 'desc')->orderBy('code')->get();
        
        return Inertia::render('Admin/Currencies/Index', [
            'currencies' => $currencies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Currencies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'decimal_places' => 'required|integer|min:0|max:4',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si cette devise est définie comme défaut, mettre à jour toutes les autres devises
        if ($request->input('is_default')) {
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        $currency = Currency::create($request->all());

        return redirect()->route('currencies.index')
            ->with('success', 'Devise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = Currency::findOrFail($id);
        
        return Inertia::render('Admin/Currencies/Show', [
            'currency' => $currency,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $currency = Currency::findOrFail($id);
        
        return Inertia::render('Admin/Currencies/Edit', [
            'currency' => $currency,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $currency = Currency::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:3|unique:currencies,code,' . $id,
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'decimal_places' => 'required|integer|min:0|max:4',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si cette devise est définie comme défaut, mettre à jour toutes les autres devises
        if ($request->input('is_default') && !$currency->is_default) {
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        $currency->update($request->all());

        return redirect()->route('currencies.index')
            ->with('success', 'Devise mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currency = Currency::findOrFail($id);
        
        // Vérifier si c'est la devise par défaut
        if ($currency->is_default) {
            return redirect()->back()
                ->with('error', 'La devise par défaut ne peut pas être supprimée.');
        }
        
        // Vérifier si des plans d'abonnement utilisent cette devise
        if ($currency->subscriptionPlans()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cette devise ne peut pas être supprimée car des plans d\'abonnement y sont associés.');
        }
        
        $currency->delete();

        return redirect()->route('currencies.index')
            ->with('success', 'Devise supprimée avec succès.');
    }
    
    /**
     * Synchronise les taux de change
     */
    public function syncRates()
    {
        $service = new CurrencyExchangeService();
        $updated = $service->syncExchangeRates();
        
        if ($updated) {
            return redirect()->route('currencies.index')
                ->with('success', 'Les taux de change ont été synchronisés avec succès.');
        } else {
            return redirect()->route('currencies.index')
                ->with('error', 'Impossible de synchroniser les taux de change. Veuillez réessayer plus tard.');
        }
    }
}
