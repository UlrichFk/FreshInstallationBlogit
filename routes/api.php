<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', 'App\Http\Controllers\API\UserAPIController@doLogin');
Route::post('signup', 'App\Http\Controllers\API\UserAPIController@doSignup');
Route::post('social-media-signup', 'App\Http\Controllers\API\UserAPIController@doSocialMediaSignup');
Route::post('forget-password', 'App\Http\Controllers\API\UserAPIController@doForgetPassword');
Route::post('reset-password', 'App\Http\Controllers\API\UserAPIController@doResetPassword');  
Route::match(['get', 'head'], 'setting-list', 'App\Http\Controllers\API\SettingAPIController@getSettings');
Route::match(['get', 'head'], 'language-list', 'App\Http\Controllers\API\SettingAPIController@getLanguages');
Route::match(['get', 'head'], 'visibility-list', 'App\Http\Controllers\API\SettingAPIController@getVisibillities');
Route::match(['get', 'head'], 'cms-list', 'App\Http\Controllers\API\SettingAPIController@getCms');
Route::match(['get', 'head'], 'epaper-list', 'App\Http\Controllers\API\SettingAPIController@getEpaper');
Route::match(['get', 'head'], 'live-news-list', 'App\Http\Controllers\API\SettingAPIController@getLiveNews');
Route::match(['get', 'head'], 'localisation-list', 'App\Http\Controllers\API\SettingAPIController@getLocalization');
Route::match(['get', 'head'], 'social-media-list', 'App\Http\Controllers\API\SettingAPIController@getSocialMedia');
Route::match(['get', 'head'], 'ads-list', 'App\Http\Controllers\API\SettingAPIController@getAds');
 
Route::match(['get', 'head'],'blog-list', 'App\Http\Controllers\API\BlogAPIController@getList');  
Route::match(['get', 'head'],'blog-detail/{id}', 'App\Http\Controllers\API\BlogAPIController@getDetail');  
Route::post('update-token', 'App\Http\Controllers\API\UserAPIController@doUpdateToken');
Route::post('get-notification-detail', 'App\Http\Controllers\API\UserAPIController@doGetNotificationDetail');
Route::post('add-analytics', 'App\Http\Controllers\API\BlogAPIController@addAnalytics');
Route::post('submit-query', 'App\Http\Controllers\API\SettingAPIController@doSubmitQuery');
Route::match(['get', 'head'], 'get-app-home-page', 'App\Http\Controllers\API\BlogAPIController@getAppHomePage');

// Donation API - Routes publiques pour permettre aux guests de faire des dons
Route::get('donation-stats', 'App\Http\Controllers\API\DonationAPIController@getDonationStats');
Route::post('create-donation', 'App\Http\Controllers\API\DonationAPIController@createDonation');
Route::post('confirm-donation', 'App\Http\Controllers\API\DonationAPIController@confirmDonation');
Route::get('recent-donations', 'App\Http\Controllers\API\DonationAPIController@getRecentDonations');
Route::get('donation-goals', 'App\Http\Controllers\API\DonationAPIController@getDonationGoals');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('apiauth:api')->group(function () {
    Route::match(['get', 'head'],'get-profile', 'App\Http\Controllers\API\UserAPIController@getProfile');
    Route::post('update-profile', 'App\Http\Controllers\API\UserAPIController@doUpdateProfile');
    Route::post('change-password', 'App\Http\Controllers\API\UserAPIController@doChangePassword');
    Route::get('delete-account', 'App\Http\Controllers\API\UserAPIController@doDeleteAccount');    
    Route::post('blog-search', 'App\Http\Controllers\API\BlogAPIController@search');
    Route::post('add-feed', 'App\Http\Controllers\API\CategoryAPIController@doAddFeed');
    Route::post('add-vote', 'App\Http\Controllers\API\BlogAPIController@doVoteForOption');
    Route::get('get-bookmarks', 'App\Http\Controllers\API\BlogAPIController@doGetBookmarks');  
    Route::post('get-comments', 'App\Http\Controllers\API\BlogAPIController@doGetComments');
    Route::post('add-comment', 'App\Http\Controllers\API\BlogAPIController@doComment');
    Route::post('report-comment', 'App\Http\Controllers\API\BlogAPIController@doReportComment');
    Route::post('delete-comment', 'App\Http\Controllers\API\BlogAPIController@doDeleteComment');
    Route::get('get-short-videos', 'App\Http\Controllers\API\BlogAPIController@getShortVideoLists');
    Route::post('do-short-video-comments', 'App\Http\Controllers\API\BlogAPIController@doShortVideoComment'); 
    Route::post('get-short-video-comment', 'App\Http\Controllers\API\BlogAPIController@getShortVideoComments');
    Route::post('report-short-video-comment', 'App\Http\Controllers\API\BlogAPIController@doReportShortVideoComment');
    Route::post('delete-short-video-comment', 'App\Http\Controllers\API\BlogAPIController@doDeleteShortVideoComment');

    // Membership API
    Route::get('membership-plans', 'App\Http\Controllers\API\MembershipAPIController@getPlans');
    Route::get('user-subscription', 'App\Http\Controllers\API\MembershipAPIController@getUserSubscription');
    Route::get('premium-content', 'App\Http\Controllers\API\MembershipAPIController@getPremiumContent');
    Route::post('check-access', 'App\Http\Controllers\API\MembershipAPIController@checkAccess');
    Route::post('cancel-subscription', 'App\Http\Controllers\API\MembershipAPIController@cancelSubscription');
    Route::get('subscription-history', 'App\Http\Controllers\API\MembershipAPIController@getSubscriptionHistory');
    
    // Donation API - Routes authentifiées uniquement pour les utilisateurs connectés
    Route::get('user-donations', 'App\Http\Controllers\API\DonationAPIController@getUserDonations');
    
    // Transaction API
    Route::get('user-transactions', 'App\Http\Controllers\API\TransactionAPIController@getUserTransactions');
    Route::get('transaction-details/{id}', 'App\Http\Controllers\API\TransactionAPIController@getTransactionDetails');
    Route::get('user-transaction-stats', 'App\Http\Controllers\API\TransactionAPIController@getUserTransactionStats');
    Route::get('recent-transactions', 'App\Http\Controllers\API\TransactionAPIController@getRecentTransactions');
});

// Restrict blog detail to subscribed users
Route::match(['get', 'head'],'blog-detail/{id}', 'App\Http\Controllers\API\BlogAPIController@getDetail')
    ->middleware('check.subscription');
