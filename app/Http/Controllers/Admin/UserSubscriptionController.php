<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\MembershipPlan;
use Carbon\Carbon;

class UserSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->all();
        $subscriptions = UserSubscription::with(['user', 'membershipPlan'])
                                        ->when(isset($search['status']), function($query) use ($search) {
                                            return $query->where('status', $search['status']);
                                        })
                                        ->when(isset($search['user_id']), function($query) use ($search) {
                                            return $query->where('user_id', $search['user_id']);
                                        })
                                        ->latest()
                                        ->paginate(config('constant.pagination'));

        $users = User::where('type', 'user')->get();
        $plans = \Illuminate\Support\Facades\Schema::hasColumn('membership_plans','status')
            ? MembershipPlan::active()->get()
            : MembershipPlan::ordered()->get();

        return view('admin.user-subscriptions.index', compact('subscriptions', 'users', 'plans'));
    }

    public function show($id)
    {
        $subscription = UserSubscription::with(['user', 'membershipPlan'])->findOrFail($id);
        return view('admin.user-subscriptions.show', compact('subscription'));
    }

    public function create()
    {
        $users = User::where('type', 'user')->get();
        $plans = \Illuminate\Support\Facades\Schema::hasColumn('membership_plans','status')
            ? MembershipPlan::active()->get()
            : MembershipPlan::ordered()->get();
        return view('admin.user-subscriptions.create', compact('users', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'amount_paid' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:active,cancelled,expired,pending,failed',
            'subscription_id' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:50',
            'payment_details' => 'nullable|array'
        ]);

        $plan = MembershipPlan::findOrFail($request->membership_plan_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($plan->duration_days);

        UserSubscription::create([
            'user_id' => $request->user_id,
            'membership_plan_id' => $request->membership_plan_id,
            'status' => $request->status,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'amount_paid' => $request->amount_paid,
            'currency' => $request->currency,
            'subscription_id' => $request->subscription_id,
            'payment_method' => $request->payment_method ?? 'manual',
            'payment_details' => $request->payment_details,
            'auto_renew' => $request->has('auto_renew')
        ]);

        return redirect()->route('admin.user-subscriptions.index')
                        ->with('success', 'Abonnement créé avec succès.');
    }

    public function edit($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $users = User::where('type', 'user')->get();
        $plans = \Illuminate\Support\Facades\Schema::hasColumn('membership_plans','status')
            ? MembershipPlan::active()->get()
            : MembershipPlan::ordered()->get();
        return view('admin.user-subscriptions.edit', compact('subscription', 'users', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $subscription = UserSubscription::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'amount_paid' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:active,cancelled,expired,pending,failed',
            'subscription_id' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:50',
            'payment_details' => 'nullable|array'
        ]);

        $subscription->update([
            'user_id' => $request->user_id,
            'membership_plan_id' => $request->membership_plan_id,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount_paid' => $request->amount_paid,
            'currency' => $request->currency,
            'subscription_id' => $request->subscription_id,
            'payment_method' => $request->payment_method ?? 'manual',
            'payment_details' => $request->payment_details,
            'auto_renew' => $request->has('auto_renew'),
            'cancelled_at' => $request->status === 'cancelled' ? now() : null
        ]);

        return redirect()->route('admin.user-subscriptions.index')
                        ->with('success', 'Abonnement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.user-subscriptions.index')
                        ->with('success', 'Abonnement supprimé avec succès.');
    }

    public function cancel($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->cancel();

        return redirect()->back()->with('success', 'Abonnement annulé avec succès.');
    }

    public function renew($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->renew();

        return redirect()->back()->with('success', 'Abonnement renouvelé avec succès.');
    }
} 