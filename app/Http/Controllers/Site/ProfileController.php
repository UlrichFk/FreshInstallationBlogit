<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\BlogAnalytic;
use App\Models\BlogBookmark;
use App\Models\Transaction;
use App\Models\Donation;
use App\Models\UserSubscription;
use App\Models\Blog;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Afficher la page de profil utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Charger les données nécessaires
        $data = [
            'user' => $user,
            'stats' => $this->getUserStats($user),
            'recentActivity' => $this->getRecentActivity($user),
            'subscription' => $this->getUserSubscription($user),
            'transactions' => $this->getUserTransactions($user),
            'donations' => $this->getUserDonations($user)
        ];

        return view('site.profile.index', $data);
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6'
        ]);

        try {
            $user = Auth::user();
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ];

            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);

            return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du profil.');
        }
    }

    /**
     * Obtenir les statistiques de l'utilisateur
     */
    private function getUserStats($user)
    {
        return [
            'articles_lus' => BlogAnalytic::where('user_id', $user->id)
                ->where('type', 'view')
                ->count(),
            'articles_sauvegardes' => BlogBookmark::where('user_id', $user->id)->count(),
            'transactions' => Transaction::where('user_id', $user->id)->count(),
            'donations' => Donation::where('user_id', $user->id)->count()
        ];
    }

    /**
     * Obtenir l'activité récente de l'utilisateur
     */
    private function getRecentActivity($user)
    {
        $lastReadArticle = BlogAnalytic::where('user_id', $user->id)
            ->where('type', 'view')
            ->latest()
            ->first();

        $lastBookmark = BlogBookmark::where('user_id', $user->id)
            ->latest()
            ->first();

        $lastDonation = Donation::where('user_id', $user->id)
            ->latest()
            ->first();

        return [
            'last_read_article' => $lastReadArticle ? Blog::find($lastReadArticle->blog_id) : null,
            'last_bookmark' => $lastBookmark ? Blog::find($lastBookmark->blog_id) : null,
            'last_donation' => $lastDonation
        ];
    }

    /**
     * Obtenir l'abonnement de l'utilisateur
     */
    private function getUserSubscription($user)
    {
        return UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->with('membershipPlan')
            ->latest()
            ->first();
    }

    /**
     * Obtenir les transactions de l'utilisateur
     */
    private function getUserTransactions($user)
    {
        return Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Obtenir les donations de l'utilisateur
     */
    private function getUserDonations($user)
    {
        return Donation::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Vérifier si l'utilisateur a un abonnement actif
     */
    public function hasActiveSubscription($user)
    {
        return UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->exists();
    }
} 