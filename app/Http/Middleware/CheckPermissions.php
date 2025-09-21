<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $permission = $this->getPermissionFromRequest($request);
        
        // Temporairement permettre l'accès aux routes membership en attendant la configuration de la DB
        if (strpos($permission, 'membership') !== false || strpos($permission, 'user-subscription') !== false || strpos($permission, 'transaction') !== false) {
            return $next($request);
        }
        
        if (Auth::check() && !Auth::user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }

    private function getPermissionFromRequest($request)
    {
        $segments = $request->segment('2');
        $segments3 = $request->segment('3');
        
        $permission = $segments;
        
        if($segments == 'ads-sortable'){
           $permission = 'ads'; 
        }
        
        if($segments == 'create-app-home-page'){
           $permission = 'dashboard'; 
        }
        
        if($segments == 'add-app-home-page'){
           $permission = 'dashboard'; 
        }
        
        if($segments == 'update-app-home-page-status'){
           $permission = 'dashboard'; 
        }
        
        if($segments == 'edit-app-home-page'){
           $permission = 'dashboard'; 
        }
        
        if($segments == 'update-app-home-page'){
           $permission = 'dashboard'; 
        }
        
        if($segments == 'delete-app-home-page'){
           $permission = 'dashboard'; 
        }
         
        if($segments == 'post'){
           $permission = 'blog'; 
        }
        
        if($segments == 'store-image'){
           $permission = 'blog'; 
        }
        
        if($segments == 'remove-image-by-name'){
           $permission = 'blog'; 
        }
        
        if($segments == 'add-post'){
            $permission = 'add-blog'; 
        }
        
        if($segments == 'add-quote'){
            $permission = 'add-blog'; 
        }
        
        if($segments == 'update-post'){
            $permission = 'update-blog'; 
        }
        
        if($segments == 'update-quote'){
            $permission = 'update-blog'; 
        }
        
        if($segments == 'delete-post'){
            $permission = 'delete-blog'; 
        }

        if($segments == 'delete-selected-post'){
            $permission = 'delete-blog'; 
        }
        
        if($segments == 'delete-selected'){
            $permission = 'delete-blog'; 
        }

        if($segments == 'delete-selected-ad'){
            $permission = 'delete-ad'; 
        }

        if($segments == 'delete-selected-short-video'){
            $permission = 'delete-short-video'; 
        }
        
        if($segments == 'update-post-status'){
            $permission = 'update-blog-status'; 
        }
        
        if($segments == 'send-notification-to-users'){
            $permission = 'push-notification';
        }
        
        if($segments == 'create-short-video'){
            $permission = 'add-short-video';
        }
        
        if($segments == 'update-short-video-status'){
            $permission = 'update-short-video-column';
        }
        
        if($segments == 'edit-short-video'){
            $permission = 'update-short-video';
        }
        
        if($segments == 'short-video-analytics'){
            $permission = 'analytics-short-video';
        }
        
        if($segments == 'check-rss'){
            $permission = 'rss-feeds';
        }
        
        if($segments == 'ad-analytics'){
            $permission = 'analytics-ad';
        }
        
        if($segments == 'send-push-notification'){
            $permission = 'push-notification';
        }
        
        if($segments == 'languages'){
            $permission = 'language';
        }
        
        if($segments == 'translation-topic'){
            $permission = 'topic-translation';
        }

        if($segments == 'update-rss-autopublish-status'){
            $permission = 'update-social-media-status';
        }

        if($segments == 'app-home-page'){
           $permission = 'settings'; 
        }

        if($segments == 'get-sources-by-category' || $segments3 == 'get-sources-by-category'){
           $permission = 'rss-feed-items'; 
        }

        if($segments == 'payment-gateways' || $segments == 'payment-settings'){
           $permission = 'settings'; 
        }

        if($segments == 'membership-plans'){
           $permission = 'membership-plans'; 
        }
        
        if($segments == 'add-membership-plan'){
           $permission = 'add-membership-plan'; 
        }
        
        if($segments == 'edit-membership-plan'){
           $permission = 'update-membership-plan'; 
        }
        
        if($segments == 'update-membership-plan'){
           $permission = 'update-membership-plan'; 
        }
        
        if($segments == 'delete-membership-plan'){
           $permission = 'delete-membership-plan'; 
        }
        
        // Route alternative de suppression (GET)
        if($segments == 'delete-membership-plan' && $request->isMethod('get')){
           $permission = 'delete-membership-plan'; 
        }
        
        if($segments == 'update-membership-plan-status'){
           $permission = 'update-membership-plan-status'; 
        }

        if($segments == 'user-subscriptions'){
           $permission = 'user-subscriptions'; 
        }
        
        if($segments == 'add-user-subscription'){
           $permission = 'add-user-subscription'; 
        }
        
        if($segments == 'edit-user-subscription'){
           $permission = 'update-user-subscription'; 
        }
        
        if($segments == 'update-user-subscription'){
           $permission = 'update-user-subscription'; 
        }
        
        if($segments == 'delete-user-subscription'){
           $permission = 'delete-user-subscription'; 
        }
        
        if($segments == 'show-user-subscription'){
           $permission = 'show-user-subscription'; 
        }
        
        if($segments == 'cancel-user-subscription'){
           $permission = 'cancel-user-subscription'; 
        }
        
        if($segments == 'renew-user-subscription'){
           $permission = 'renew-user-subscription'; 
        }

        if($segments == 'transactions'){
           $permission = 'transactions'; 
        }
        
        return $permission;
    }
}
