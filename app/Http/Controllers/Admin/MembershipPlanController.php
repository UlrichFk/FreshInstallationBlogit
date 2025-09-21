<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Validator;

class MembershipPlanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->all();
        $plans = MembershipPlan::getLists($search);
        return view('admin.membership-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.membership-plans.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'stripe_price_id' => 'nullable|string|max:255',
            'paypal_plan_id' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        MembershipPlan::create($data);

        return redirect()->route('admin.membership-plans.index')
                        ->with('success', 'Plan d\'abonnement créé avec succès.');
    }

    public function edit($id)
    {
        $plan = MembershipPlan::findOrFail($id);
        return view('admin.membership-plans.edit', compact('plan'));
    }

    public function update(Request $request)
    {
        $plan = MembershipPlan::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'stripe_price_id' => 'nullable|string|max:255',
            'paypal_plan_id' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $plan->update($data);

        return redirect()->route('admin.membership-plans.index')
                        ->with('success', 'Plan d\'abonnement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        try {
            $plan = MembershipPlan::findOrFail($id);
            
            // Vérifier s'il y a des abonnements actifs
            if ($plan->activeSubscriptions()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce plan car il a des abonnements actifs.'
                ], 400);
            }

            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan d\'abonnement supprimé avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus($id, $status)
    {
        try {
            $plan = MembershipPlan::findOrFail($id);
            $plan->update(['is_active' => $status]);

            $statusText = $status ? 'activé' : 'désactivé';
            return response()->json([
                'success' => true,
                'message' => "Plan d'abonnement $statusText avec succès."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut: ' . $e->getMessage()
            ], 500);
        }
    }

    // Méthode alternative de suppression via GET (pour contourner les problèmes de DELETE)
    public function deletePlan($id)
    {
        try {
            $plan = MembershipPlan::findOrFail($id);
            
            // Vérifier s'il y a des abonnements actifs
            if ($plan->activeSubscriptions()->count() > 0) {
                return redirect()->back()->with('error', 'Impossible de supprimer ce plan car il a des abonnements actifs.');
            }

            $plan->delete();

            return redirect()->route('admin.membership-plans.index')
                            ->with('success', 'Plan d\'abonnement supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
} 