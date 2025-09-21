<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\UserSubscription;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class MembershipAPIController extends Controller
{
    private $language;
    
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->language = $request->header('language-code') && $request->header('language-code') != '' ? $request->header('language-code') : 'en';
    }

    public function getPlans(Request $request)
    {
        try {
            $plans = \Illuminate\Support\Facades\Schema::hasColumn('membership_plans','status')
                ? MembershipPlan::active()->ordered()->get()
                : MembershipPlan::ordered()->get();
            
            foreach ($plans as $plan) {
                $plan->formatted_price = $plan->formatted_price;
                $plan->duration_text = $plan->duration_text;
            }

            return $this->sendResponse($plans, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function getUserSubscription(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $subscription = auth()->user()->activeSubscription();
        
        if (!$subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Aucun abonnement actif trouvé',
                'has_subscription' => false
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'subscription' => $subscription,
                'plan' => $subscription->membershipPlan,
                'days_remaining' => $subscription->days_remaining,
                'is_active' => $subscription->is_active
            ]
        ]);
    }

    public function getPremiumContent(Request $request)
    {
        try {
            if (!$request->userAuthData) {
                return $this->sendError(__('lang.message_user_not_found'));
            }

            $user = $request->userAuthData;
            $pagination_no = config('constant.api_pagination');
            
            if (isset($request->per_page) && !empty($request->per_page)) {
                $pagination_no = $request->per_page;
            }

            $blogs = Blog::select('id', 'type', 'title', 'description', 'source_name', 'source_link', 'video_url', 'is_voting_enable', 'schedule_date', 'created_at', 'updated_at', 'background_image', 'is_featured', 'is_premium', 'premium_content', 'required_plan_id')
                        ->where('status', 1)
                        ->where('schedule_date', '<=', date("Y-m-d H:i:s"))
                        ->where(function($query) {
                            $query->where('is_premium', true)
                                  ->orWhereNotNull('required_plan_id');
                        })
                        ->with(['blog_category', 'blog_sub_category'])
                        ->orderBy('schedule_date', 'DESC')
                        ->paginate($pagination_no);

            if (count($blogs)) {
                foreach ($blogs as $blog) {
                    $blogTranslate = \App\Models\BlogTranslation::where('blog_id', $blog->id)
                        ->where('language_code', $this->language)
                        ->first();
                    
                    if ($blogTranslate) {
                        $blog->title = $blogTranslate->title;
                        $blog->description = $blogTranslate->description;
                    }

                    $blog->voice = setting('blog_voice');
                    $blog->accent_code = setting('blog_accent');
                    $blog->is_feed = false;
                    $blog->is_vote = 0;
                    $blog->is_bookmark = 0;
                    $blog->is_user_viewed = 0;
                    $blog->is_user_liked = 0;
                    $blog->like_count = \Helpers::getLikeCount($blog->id);
                    $blog->can_access = $blog->canUserAccess($user);

                    if ($request->header('api-token') != '') {
                        $blog->is_feed = \Helpers::categoryIsInFeed($blog->id, $user->id);
                        $blog->is_vote = \Helpers::getVotes($blog->id, $user->id);
                        $blog->is_bookmark = \Helpers::getBookmarks($blog->id, $user->id);
                        $blog->is_user_viewed = \Helpers::getViewed($blog->id, $user->id);
                        $blog->is_user_liked = \Helpers::getLiked($blog->id, $user->id);
                    }

                    $blog->visibilities = \Helpers::getVisibilities($blog->id);
                    $blog->question = \Helpers::getQuestionsOptions($blog->id);
                    $blog->images = \Helpers::getBlogImages($blog->id, '768x428');
                    
                    if ($blog->background_image != '') {
                        $blog->background_image = url('uploads/blog/' . $blog->background_image);
                    }

                    $blog->blog_sub_category_ids = $blog->blog_sub_category->pluck('category_id');
                    unset($blog->blog_sub_category);
                    unset($blog->blog_category);
                }
            }

            return $this->sendResponse($blogs, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function checkAccess(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id'
        ]);

        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié',
                'requires_login' => true
            ], 401);
        }

        $user = auth()->user();
        $blog = Blog::findOrFail($request->blog_id);

        if ($blog->isPremiumContent()) {
            if (!$user->hasActiveSubscription()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Abonnement requis pour accéder à ce contenu',
                    'requires_subscription' => true,
                    'blog_id' => $blog->id
                ], 403);
            }

            // Vérifier si l'utilisateur a le bon plan d'abonnement
            if ($blog->required_plan_id && $user->activeSubscription()->membership_plan_id != $blog->required_plan_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plan d\'abonnement spécifique requis',
                    'requires_upgrade' => true,
                    'blog_id' => $blog->id
                ], 403);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Accès autorisé',
            'can_access' => true
        ]);
    }

    public function cancelSubscription(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $user = auth()->user();
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            return response()->json([
                'status' => false,
                'message' => 'Aucun abonnement actif à annuler'
            ], 404);
        }

        $subscription->cancel();

        return response()->json([
            'status' => true,
            'message' => 'Abonnement annulé avec succès'
        ]);
    }

    public function getSubscriptionHistory(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        $user = auth()->user();
        $subscriptions = UserSubscription::where('user_id', $user->id)
            ->with('membershipPlan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $subscriptions
        ]);
    }
} 