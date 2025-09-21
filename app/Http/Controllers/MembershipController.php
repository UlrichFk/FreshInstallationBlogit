<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\UserSubscription;
use App\Models\User;

class MembershipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $plans = \Illuminate\Support\Facades\Schema::hasColumn('membership_plans','status')
            ? MembershipPlan::active()->ordered()->get()
            : MembershipPlan::ordered()->get();
        $activeSubscription = $user ? $user->activeSubscription() : null;
        
        return view('site.membership.index', compact('plans', 'activeSubscription'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:membership_plans,id'
        ]);

        $plan = MembershipPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', __('messages.must_be_logged_in'));
        }

        return view('site.membership.subscribe', compact('plan', 'user'));
    }

    public function status()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $activeSubscription = $user->activeSubscription();
        $subscriptionHistory = $user->subscriptions()->with('membershipPlan')->latest()->get();

        return view('site.membership.status', compact('activeSubscription', 'subscriptionHistory'));
    }
}