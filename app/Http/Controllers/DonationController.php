<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\User;

class DonationController extends Controller
{
    public function showForm()
    {
        $recentDonations = Donation::completed()
            ->latest()
            ->take(5)
            ->get();
            
        $donationStats = [
            'total_donations' => Donation::completed()->count(),
            'total_amount' => Donation::completed()->sum('amount'),
            'monthly_donations' => Donation::completed()
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        return view('site.donation.index', compact('recentDonations', 'donationStats'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
            'recurring_interval' => 'required_if:is_recurring,1|nullable|in:monthly,yearly',
            'payment_method' => 'required|in:stripe,paypal'
        ]);

        $user = auth()->user();

        $donation = Donation::create([
            'user_id' => $user ? $user->id : null,
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'message' => $request->message,
            'amount' => $request->amount,
            'currency' => 'USD',
            'is_anonymous' => $request->has('is_anonymous'),
            'is_recurring' => $request->has('is_recurring'),
            'recurring_interval' => $request->recurring_interval,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // Redirect to payment processing
        if ($request->payment_method === 'stripe') {
            return redirect()->route('payment.stripe.donation')->with('donation_id', $donation->id);
        } else {
            return redirect()->route('payment.paypal.donation')->with('donation_id', $donation->id);
        }
    }
} 