<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::with('currency')->orderBy('sort_order')->get();
        
        return Inertia::render('Admin/SubscriptionPlans/Index', [
            'plans' => $plans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::where('is_active', true)->get();
        
        return Inertia::render('Admin/SubscriptionPlans/Create', [
            'currencies' => $currencies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug',
            'description' => 'required|string',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'features' => 'required|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plan = SubscriptionPlan::create($request->all());

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Plan d\'abonnement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = SubscriptionPlan::with('currency')->findOrFail($id);
        
        return Inertia::render('Admin/SubscriptionPlans/Show', [
            'plan' => $plan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $currencies = Currency::where('is_active', true)->get();
        
        return Inertia::render('Admin/SubscriptionPlans/Edit', [
            'plan' => $plan,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $id,
            'description' => 'required|string',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'features' => 'required|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plan->update($request->all());

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Plan d\'abonnement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        
        // Vérifier si des abonnements utilisent ce plan avant de le supprimer
        if ($plan->userSubscriptions()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Ce plan ne peut pas être supprimé car des abonnements y sont associés.');
        }
        
        $plan->delete();

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Plan d\'abonnement supprimé avec succès.');
    }
}
