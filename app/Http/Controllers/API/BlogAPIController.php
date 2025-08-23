<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use Validator;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogCategory;
use App\Models\SearchLog;
use App\Models\Vote;
use App\Models\BlogTranslation;
use App\Models\Ad;
use App\Models\AdAnalytic;
use App\Models\User;
use App\Models\BlogAnalytic;
use App\Models\BlogBookmark;
use App\Models\Comment;
use App\Models\ShortVideoComment;
use App\Models\ReportComment;
use App\Models\CategoryTranslation;
use App\Models\ShortVideo;
use App\Models\ShortVideoAnalytic;
use App\Models\AppHomePage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class BlogAPIController extends Controller
{
    private $language;
    
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->language = $request->header('language-code') && $request->header('language-code') != '' ? $request->header('language-code') : 'en';
    }

    function getList(Request $request)
    {
        try{            
            $pagination_no = config('constant.api_pagination');
            if(isset($search['per_page']) && !empty($search['per_page'])){
                $pagination_no = $search['per_page'];
            }
            $categories = Category::select('id','parent_id','name','image','color','is_featured','created_at','updated_at','deleted_at')->where('parent_id',0)->where('status',1)->get();
            if(count($categories)){
                foreach($categories as $category_data){
                    $category_data->image = url('uploads/category/'.$category_data->image);
                    $categoryTranslate = CategoryTranslation::where('category_id',$category_data->id)->where('language_code',$this->language)->first();
                    if ($categoryTranslate) {
                        $category_data->name = $categoryTranslate->name;
                    }
                    
                    
                    // Get subcategories for the category
                    $blog_sub_category = Category::select('id', 'parent_id', 'name', 'slug', 'image', 'color')
                    ->where('parent_id', $category_data->id)
                    ->where('status', 1)
                    ->get();

                    // Add subcategory image URLs and translations
                    foreach ($blog_sub_category as $subcategory) {
                        $subcategory->image = url('uploads/category/'.$subcategory->image);
    
                        $subcategoryTranslate = CategoryTranslation::where('category_id', $subcategory->id)
                            ->where('language_code', $this->language)
                            ->first();
                        if ($subcategoryTranslate) {
                            $subcategory->name = $subcategoryTranslate->name;
                        }
                        
                        $subcategory->is_feed = false;
                        
                        if($request->header('api-token')!=''){
                            $user = User::where('api_token',$request->header('api-token'))->first();
                            if($user){
                                $subcategory->is_feed = \Helpers::categoryIsInFeed($subcategory->id,$user->id);
                            }                
                        }
                    }
    
                    // Assign subcategories to the category
                    $category_data->blog_sub_category = $blog_sub_category;
                }
            }
            if(count($categories)){
                foreach($categories as $row){
                    $row->is_feed = false;
                    $row->api_token = $request->header('api-token');
                    if($request->header('api-token')!=''){
                        $user = User::where('api_token',$request->header('api-token'))->first();
                        if($user){
                            $row->is_feed = \Helpers::categoryIsInFeed($row->id,$user->id);
                        }                
                    }
                    $blog_arr = array();
                    $blog_arr = \Helpers::getBlogsArrOnTheBasisOfCategory($row->id);
                    $row->blogs = Blog::select('id', 'type', 'title','description', 'short_description', 'source_name', 'source_link','voice', 'accent_code','video_url', 'is_voting_enable', 'schedule_date','created_at', 'updated_at', 'background_image','is_featured')->where('status',1)->whereIn('id',$blog_arr)->where('schedule_date',"<=",date("Y-m-d H:i:s"))->with('blog_sub_category')->orderBy('schedule_date','DESC')->paginate($pagination_no)->appends('per_page', $pagination_no);
                    if(count($row->blogs)){
                        foreach($row->blogs as $blog){
                            $blog->description = $blog->short_description;
                            $blogTranslate = BlogTranslation::where('blog_id',$blog->id)->where('language_code',$this->language)->first();
                            if ($blogTranslate) {
                                $blog->title = $blogTranslate->title;
                                $blog->description = $blog->short_description;
                            }
                            $blog->is_feed = false;
                            $blog->is_vote = 0;
                            $blog->is_bookmark = 0;
                            $blog->is_user_viewed = 0; 
                            $blog->is_user_liked = 0; 
                            $blog->like_count = \Helpers::getLikeCount($blog->id);
                            if($request->header('api-token')!=''){
                                $user = User::where('api_token',$request->header('api-token'))->first();
                                if($user){
                                    $blog->is_feed = \Helpers::categoryIsInFeed($row->id,$user->id);
                                    $blog->is_vote = \Helpers::getVotes($blog->id,$user->id);              
                                    $blog->is_bookmark = \Helpers::getBookmarks($blog->id,$user->id);              
                                    $blog->is_user_viewed = \Helpers::getViewed($blog->id,$user->id);      
                                    $blog->is_user_liked = \Helpers::getLiked($blog->id,$user->id);        
                                }  
                            } 
                                                       
                            $blog->visibilities = \Helpers::getVisibilities($blog->id);
                            $blog->question = \Helpers::getQuestionsOptions($blog->id);
                            $blog->images = \Helpers::getBlogImages($blog->id,'768x428');
                            if($blog->background_image!=''){
                                $blog->background_image = url('uploads/blog/'.$blog->background_image);
                            }
                            
                            $blog->blog_sub_category_ids = $blog->blog_sub_category->pluck('category_id');
                            unset($blog->blog_sub_category);
                            unset($blog->short_description);
                        }
                    }
                }
            }
            $response = $this->sendResponse($categories, __('lang.message_data_retrived_successfully'));  
            return $response;
            // return $this->sendResponse($categories, __('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    function getDetail(Request $request,$id)
    {
        try{
            $blog = Blog::select('id', 'type', 'title','description', 'source_name', 'source_link','video_url', 'is_voting_enable', 'schedule_date','created_at', 'updated_at', 'background_image','is_featured')->where('status',1)->where('id',$id)->with('blog_category')->with('blog_sub_category')->first();
            if($blog){
                $blog->images = \Helpers::getBlogImages($blog->id,'768x428');
                if($blog->background_image!=''){
                    $blog->background_image = url('uploads/blog/'.$blog->background_image);
                }
                $blog->voice = setting('blog_voice');
                $blog->accent_code = setting('blog_accent');

                $blogTranslate = BlogTranslation::where('blog_id',$blog->id)->where('language_code',$this->language)->first();
                if ($blogTranslate) {
                    $blog->title = $blogTranslate->title;
                    $blog->description = $blogTranslate->description;
                }
                $blog->is_feed = false;
                $blog->is_vote = 0;
                $blog->is_bookmark = 0;
                $blog->is_user_viewed = 0; 
                $blog->is_user_liked = 0; 
                $blog->like_count = \Helpers::getLikeCount($blog->id);
                if($request->header('api-token')!=''){
                    $user = User::where('api_token',$request->header('api-token'))->first();
                    if($user){
                        $blog->is_feed = \Helpers::categoryIsInFeed($row->id,$user->id);
                        $blog->is_vote = \Helpers::getVotes($blog->id,$user->id);              
                        $blog->is_bookmark = \Helpers::getBookmarks($blog->id,$user->id);              
                        $blog->is_user_viewed = \Helpers::getViewed($blog->id,$user->id);      
                        $blog->is_user_liked = \Helpers::getLiked($blog->id,$user->id);        
                    }  
                } 
                                            
                $blog->visibilities = \Helpers::getVisibilities($blog->id);
                $blog->question = \Helpers::getQuestionsOptions($blog->id);
                if(count($blog->blog_sub_category)){
                    foreach($blog->blog_sub_category as $blog_sub_category){
                        if($blog_sub_category->category!=''){
                            if($blog_sub_category->category->image!=''){
                                $blog_sub_category->category->image = url('uploads/category/'.$blog_sub_category->category->image);
                            }
                        }
                    }
                }
            }
            return $this->sendResponse($blog, __('lang.message_data_retrived_successfully')); 

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    function search(Request $request)
    {
        try {
            if ($request->userAuthData) {
                $keyword = trim($request->input('keyword'));
                $languageCode = $this->language;
    
                $blogs = Blog::select('id', 'type', 'title', 'description', 'source_name', 'source_link', 'video_url', 'is_voting_enable', 'schedule_date', 'created_at', 'updated_at', 'background_image', 'is_featured')
                    ->where(function ($query) use ($keyword, $languageCode) {
                        $query->where('title', 'like', '%' . $keyword . '%')
                            ->orWhere('description', 'like', '%' . $keyword . '%')
                            ->orWhereHas('translations', function ($query) use ($keyword, $languageCode) {
                                $query
                                    // ->where('language_code', $languageCode)
                                    ->where('title', 'like', '%' . $keyword . '%')
                                    ->orWhere('description', 'like', '%' . $keyword . '%');
                            });
                    })
                    ->where('status', 1)
                    ->where('schedule_date', '<=', date("Y-m-d H:i:s"))
                    ->with('blog_category')
                    ->get();
    
                if (count($blogs)) {
                    foreach ($blogs as $blog) {
                        $blogTranslate = BlogTranslation::where('blog_id', $blog->id)->where('language_code', $this->language)->first();
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
    
                        if ($request->header('api-token') != '') {
                            $user = User::where('api_token', $request->header('api-token'))->first();
                            if ($user) {
                                $blog->is_feed = \Helpers::categoryIsInFeed($blog->id, $user->id);
                                $blog->is_vote = \Helpers::getVotes($blog->id, $user->id);
                                $blog->is_bookmark = \Helpers::getBookmarks($blog->id, $user->id);
                                $blog->is_user_viewed = \Helpers::getViewed($blog->id, $user->id);
                            }
                        }
    
                        $blog->visibilities = \Helpers::getVisibilities($blog->id);
                        $blog->question = \Helpers::getQuestionsOptions($blog->id);
                        $blog->images = \Helpers::getBlogImages($blog->id, '768x428');
                        if ($blog->background_image != '') {
                            $blog->background_image = url('uploads/blog/' . $blog->background_image);
                        }
                        if (count($blog->blog_sub_category)) {
                            foreach ($blog->blog_sub_category as $blog_sub_category) {
                                if ($blog_sub_category->category != '') {
                                    if ($blog_sub_category->category->image != '') {
                                        $categoryTranslate = CategoryTranslation::where('category_id', $blog_sub_category->category->id)->where('language_code', $this->language)->first();
                                        if ($categoryTranslate) {
                                            $blog_sub_category->category->name = $categoryTranslate->name;
                                        }
                                        $blog_sub_category->category->image = url('uploads/category/' . $blog_sub_category->category->image);
                                    }
                                }
                            }
                        }
                        if (count($blog->blog_category)) {
                            foreach ($blog->blog_category as $blog_category) {
                                if ($blog_category->category != '') {
                                    if ($blog_category->category->image != '') {
                                        $categoryTranslate = CategoryTranslation::where('category_id', $blog_category->category->id)->where('language_code', $this->language)->first();
                                        if ($categoryTranslate) {
                                            $blog_category->category->name = $categoryTranslate->name;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
    
                $search = array(
                    'user_id' => $request->userAuthData->id,
                    'keyword' => $request->input('keyword'),
                    'count' => count($blogs),
                    'created_at' => date('Y-m-d h:i:s')
                );
                SearchLog::insert($search);
    
                return $this->sendResponse($blogs, __('lang.message_data_retrived_successfully'));
            } else {
                return $this->sendError(__('lang.message_user_not_found'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doVoteForOption(Request $request)
    {
        try{
            if($request->userAuthData){
                $validate = [
                    'blog_id' => 'required',
                    'option_id' => 'required'
                ];
                $validator = Validator::make($request->all(), $validate);
                if ($validator->fails()) {
                    return $this->sendError(__('lang.message_required_message'),$validator->errors());
                }                
                $checkVote = Vote::where('blog_id', $request->input('blog_id'))->where('user_id',$request->userAuthData->id)->first();
                if ($checkVote) {
                    return $this->sendError(__('lang.message_vote_already_exist'));
                }
        
                $postData = array(
                    'blog_id'=>$request->input('blog_id'),
                    'option_id'=>$request->input('option_id'),
                    'user_id'=>$request->userAuthData->id,
                    'created_at' => date("Y-m-d H:i:s")
                );
                Vote::insert($postData);
                
                $analyticsArr = array(
                    'type'=> 'blog_poll_option',
                    'user_id'=> $request->userAuthData->id,
                    'blog_id' => $request->input('blog_id'),
                    'blog_poll_option_id' => $request->input('option_id'),
                    'created_at'=> date('Y-m-d H:i:s'),
                );   
                
                BlogAnalytic::insert($analyticsArr);
                
                $data = \Helpers::getQuestionsOptions($request->input('blog_id'));
                return $this->sendResponse($data, __('lang.message_vote_added_successfully'));
            }
            return $this->sendError(__('lang.message_user_not_found'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function addAnalytics(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            
            
            $fcm_token = '';
            if($request->header('fcm-token')!=''){
                $fcm_token = $request->header('fcm-token');          
            }
            
            if(isset($post) && !empty($post)){
                foreach($post as $post_data){  

                    if(isset($post_data['data_type']) && $post_data['data_type']=='ads'){
                        if($post_data['type']=='view' || $post_data['type']=='click'){
                            for($i=0;$i<count($post_data['ads_ids']);$i++){
                                $checkAnalytics = AdAnalytic::where('type',$post_data['type'])->where('user_id',$user_id)->where('ad_id',$post_data['ads_ids'][$i])->first();
                                if(!$checkAnalytics){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'ad_id' => $post_data['ads_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );                                
                                    AdAnalytic::insert($analyticsArr);
                                }
                            }
                        }    
                    }elseif(isset($post_data['data_type']) && $post_data['data_type']=='shorts'){
                        
                        if($post_data['type']=='view' || $post_data['type']=='share' ){
                            for($i=0;$i<count($post_data['shorts_ids']);$i++){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'fcm_token' => $fcm_token,
                                        'short_video_id' => $post_data['shorts_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );                                
                                    ShortVideoAnalytic::insert($analyticsArr);
                            }
                        }
                        
                        
                        if($post_data['type']=='like'){
                            for($i=0;$i<count($post_data['shorts_ids']);$i++){
                                $checkAnalytics = ShortVideoAnalytic::where('type',$post_data['type'])->where('user_id',$user_id)->where('short_video_id',$post_data['shorts_ids'][$i])->first();
                                if(!$checkAnalytics){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'fcm_token' => $fcm_token,
                                        'short_video_id' => $post_data['shorts_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );                                
                                    ShortVideoAnalytic::insert($analyticsArr);
                                }else{
                                    $checkAnalytics->delete();
                                }
                            }
                        }
                        
                    }else{         
                        if($post_data['type']=='bookmark'){
                            for($i=0;$i<count($post_data['blog_ids']);$i++){
                                $checkBookmark = BlogBookmark::where('user_id',$user_id)->where('blog_id',$post_data['blog_ids'][$i])->first();
                                if(!$checkBookmark){
                                    $analyticsArr = array(
                                        'user_id'=>$user_id,
                                        'blog_id'=>$post_data['blog_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );
                                    BlogBookmark::insert($analyticsArr);
                                }                            
                            }                        
                        } 
                        if($post_data['type']=='view' || $post_data['type']=='share' || $post_data['type']=='poll_share'){
                            for($i=0;$i<count($post_data['blog_ids']);$i++){
                                $checkAnalytics = BlogAnalytic::where('type',$post_data['type'])->where('user_id',$user_id)->where('blog_id',$post_data['blog_ids'][$i])->first();
                                if(!$checkAnalytics){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'blog_id' => $post_data['blog_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );                                
                                    BlogAnalytic::insert($analyticsArr);
                                }
                            }    
                        }
                        if($post_data['type']=='blog_time_spent' || $post_data['type']=='tts'){
                            if(isset($post_data['blogs']) && count($post_data['blogs'])){
                                foreach($post_data['blogs'] as $blog_time_spent){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'blog_id'=>$blog_time_spent['id'],
                                        'start_date_time'=>date("Y-m-d H:i:s",strtotime($blog_time_spent['start_time'])),
                                        'end_date_time'=>date("Y-m-d H:i:s",strtotime($blog_time_spent['end_time'])),
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );
                                    BlogAnalytic::insert($analyticsArr);                                
                                }                            
                            }
                        }
                        if($post_data['type']=='app_time_spent'){
                            $analyticsArr = array(
                                'type'=>$post_data['type'],
                                'user_id'=>$user_id,
                                'start_date_time'=>date("Y-m-d H:i:s",strtotime($post_data['start_time'])),
                                'end_date_time'=>date("Y-m-d H:i:s",strtotime($post_data['end_time'])),
                                'created_at'=>date('Y-m-d H:i:s'),
                            );
                            BlogAnalytic::insert($analyticsArr);
                        } 
                        if($post_data['type']=='social_media_signin' || $post_data['type']=='sign_in' || $post_data['type']=='social_media_signup' || $post_data['type']=='sign_up'){
                            $checkAnalytics = BlogAnalytic::where('type',$post_data['type'])->where('user_id',$user_id)->first();
                            if(!$checkAnalytics){
                                $analyticsArr = array(
                                    'type'=>$post_data['type'],
                                    'user_id'=>$user_id,
                                    'created_at'=>date('Y-m-d H:i:s'),
                                );
                                if(isset($post_data['start_time']) && $post_data['start_time']!=''){
                                    $analyticsArr['start_date_time'] = date("Y-m-d H:i:s",strtotime($post_data['start_time']));
                                }
                                if(isset($post_data['end_time']) && $post_data['end_time']!=''){
                                    $analyticsArr['end_date_time'] = date("Y-m-d H:i:s",strtotime($post_data['end_time']));
                                }
                                if(isset($post_data['action']) && $post_data['action']!=''){
                                    $analyticsArr['action'] = $post_data['action'];
                                }
                                BlogAnalytic::insert($analyticsArr);
                            }else{
                                $analyticsArr = array(
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                );
                                if(isset($post_data['start_time']) && $post_data['start_time']!=''){
                                    $analyticsArr['start_date_time'] = date("Y-m-d H:i:s",strtotime($post_data['start_time']));
                                }
                                if(isset($post_data['end_time']) && $post_data['end_time']!=''){
                                    $analyticsArr['end_date_time'] = date("Y-m-d H:i:s",strtotime($post_data['end_time']));
                                }
                                if(isset($post_data['action']) && $post_data['action']!=''){
                                    $analyticsArr['action'] = $post_data['action'];
                                }
                                BlogAnalytic::where('id',$checkAnalytics->id)->update($analyticsArr);
                            }
                        }
                        if($post_data['type']=='remove_bookmark'){
                            for($i=0;$i<count($post_data['blog_ids']);$i++){
                                $checkBookmark = BlogBookmark::where('user_id',$user_id)->where('blog_id',$post_data['blog_ids'][$i])->first();
                                if($checkBookmark){
                                    BlogBookmark::where('user_id',$user_id)->where('blog_id',$post_data['blog_ids'][$i])->delete();
                                }                            
                            } 
                        }
                        if($post_data['type']=='logout'){
                            $checkToken = DeviceToken::where('user_id',$user_id)->update(['player_id'=>null]);
                            $analyticsArr = array(
                                'type'=>$post_data['type'],
                                'user_id'=>$user_id,
                                'created_at'=>date('Y-m-d H:i:s'),
                            );
                            BlogAnalytic::insert($analyticsArr);
                        }
                        if($post_data['type']=='like'){
                            for($i=0;$i<count($post_data['blog_ids']);$i++){
                                $checkAnalytics = BlogAnalytic::where('type',$post_data['type'])->where('user_id',$user_id)->where('blog_id',$post_data['blog_ids'][$i])->first();
                                if(!$checkAnalytics){
                                    $analyticsArr = array(
                                        'type'=>$post_data['type'],
                                        'user_id'=>$user_id,
                                        'blog_id' => $post_data['blog_ids'][$i],
                                        'created_at'=>date('Y-m-d H:i:s'),
                                    );                                
                                    BlogAnalytic::insert($analyticsArr);
                                }else{
                                   $checkAnalytics->delete();  
                                }
                            }    
                        }
                    }
                }
            }
            return $this->sendResponse([],__('lang.message_data_retrived_successfully'));
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    function doGetBookmarks(Request $request)
    {
        try{
            if($request->userAuthData){
                $pagination_no = config('constant.api_pagination');
                if(isset($search['per_page']) && !empty($search['per_page'])){
                    $pagination_no = $search['per_page'];
                }
                $blog_id_arr = array();
                $bookmarks = BlogBookmark::where('user_id',$request->userAuthData->id)->get();
                if(count($bookmarks)){
                    foreach($bookmarks as $bookmarks_data){
                        if(!in_array($bookmarks_data->blog_id,$blog_id_arr)){
                            array_push($blog_id_arr,$bookmarks_data->blog_id);
                        }
                    }
                }
                $blogs = array();
                if(count($blog_id_arr)){
                    $blogs = Blog::select('id', 'type', 'title','description', 'source_name', 'source_link','voice', 'accent_code','video_url', 'is_voting_enable', 'schedule_date','created_at', 'updated_at', 'background_image','is_featured')->where('status',1)->whereIn('id',$blog_id_arr)->where('schedule_date',"<=",date("Y-m-d H:i:s"))->with('blog_category')->with('blog_sub_category')->orderBy('schedule_date','DESC')->paginate($pagination_no)->appends('per_page', $pagination_no);
                    if(count($blogs)){
                        foreach($blogs as $blog){
                            $blogTranslate = BlogTranslation::where('blog_id',$blog->id)->where('language_code',$this->language)->first();
                            if ($blogTranslate) {
                                $blog->title = $blogTranslate->title;
                                $blog->description = $blogTranslate->description;
                            }
                            $blog->is_feed = false;
                            $blog->is_vote = 0;
                            $blog->is_bookmark = 0;
                            $blog->is_user_viewed = 0; 
                            $blog->is_user_liked = 0; 
                            $blog->like_count = \Helpers::getLikeCount($blog->id);
                            if($request->header('api-token')!=''){
                                $user = User::where('api_token',$request->header('api-token'))->first();
                                if($user){
                                    $blog->is_feed = \Helpers::categoryIsInFeed($blog   ->id,$user->id);
                                    $blog->is_vote = \Helpers::getVotes($blog->id,$user->id);              
                                    $blog->is_bookmark = \Helpers::getBookmarks($blog->id,$user->id);              
                                    $blog->is_user_viewed = \Helpers::getViewed($blog->id,$user->id);      
                                    $blog->is_user_liked = \Helpers::getLiked($blog->id,$user->id);        
                                }  
                            }  
                                                       
                            $blog->visibilities = \Helpers::getVisibilities($blog->id);
                            $blog->question = \Helpers::getQuestionsOptions($blog->id);
                            $blog->images = \Helpers::getBlogImages($blog->id,'768x428');
                            if($blog->background_image!=''){
                                $blog->background_image = url('uploads/blog/'.$blog->background_image);
                            }
                            if(count($blog->blog_sub_category)){
                                foreach($blog->blog_sub_category as $blog_sub_category){
                                    if($blog_sub_category->category!=''){
                                        if($blog_sub_category->category->image!=''){
                                            $blog_sub_category->category->image = url('uploads/category/'.$blog_sub_category->category->image);
                                            $categoryTranslate = CategoryTranslation::where('category_id',$blog_sub_category->category->id)->where('language_code',$this->language)->first();
                                            if ($categoryTranslate) {
                                                $blog_sub_category->category->name = $categoryTranslate->name;
                                            }
                                        }
                                    }
                                }
                            }
                            if(count($blog->blog_category)){
                                foreach($blog->blog_category as $blog_category){
                                    if($blog_category->category!=''){
                                        if($blog_category->category->image!=''){
                                            $categoryTranslate = CategoryTranslation::where('category_id',$blog_category->category->id)->where('language_code',$this->language)->first();
                                            if ($categoryTranslate) {
                                                $blog_category->category->name = $categoryTranslate->name;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return $this->sendResponse($blogs, __('lang.message_data_retrived_successfully'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doComment(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){
                $commentArr = array(
                    'user_id'=>$user_id,
                    'blog_id' => $post['blog_id'],
                    'comment'=>$post['comment'],
                    'created_at'=>date('Y-m-d H:i:s'),
                );    
                if(setting('is_autoapprove_enable')==1){
                    $commentArr['approval_status'] = 1;
                }                            
                Comment::insert($commentArr);
                if(setting('is_autoapprove_enable')==1){
                    $message = __('lang.message_successfully_commented');
                }else{
                    $message = __('lang.message_successfully_commented_and_submitted_for_approval');
                }
                 return $this->sendResponse($commentArr,$message);
                    
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doGetComments(Request $request)
    {
        try{
            $post = $request->all();
            if(isset($post) && !empty($post)){
                $comments = Comment::where('blog_id',$post['blog_id'])->where('status',1)->where('approval_status',1)->get();
                if(count($comments)){
                    foreach($comments as $comment){         
                        $user = User::select('id','name','photo')->where('id',$comment->user_id)->first();  
                        if($user){
                            if($user->photo!=''){
                                $user->photo = url('uploads/user/'.$user->photo);
                            }
                        } 
                        $comment->user = $user;
                    }
                }
                return $this->sendResponse($comments, __('lang.message_data_retrived_successfully'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }            
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doReportComment(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){
                $commentArr = array(
                    'user_id'=>$user_id,
                    'comment_id' => $post['comment_id'],
                    'created_at'=>date('Y-m-d H:i:s'),
                );                                
                ReportComment::insert($commentArr);
                return $this->sendResponse([],__('lang.message_successfully_reported'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doDeleteComment(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){                               
                Comment::where('user_id',$user_id)->where('id',$post['id'])->delete();
                return $this->sendResponse([],__('lang.message_comment_deleted_successfully'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }
    
    public function getShortVideoLists(Request $request)
    {
        try{            
            $pagination_no = config('constant.api_pagination');
            
            if(isset($search['per_page']) && !empty($search['per_page'])){
                $pagination_no = $search['per_page'];
            }
            
            $short_videos = ShortVideo::orderBy('schedule_date','DESC')->paginate($pagination_no)->appends('per_page', $pagination_no);
            
            if(count($short_videos)){
                foreach($short_videos as $row){
                    $row->is_user_viewed = 0; 
                    $row->is_user_liked = 0; 
                    $row->like_count = \Helpers::getShortVideoLikeCount($row->id);
                    $row->comment_count = \Helpers::getShortVideoCommentCount($row->id);
                    if($request->header('api-token')!=''){
                        $user = User::where('api_token',$request->header('api-token'))->first();
                        if($user){
                            $row->is_user_viewed = \Helpers::getShortVideoViewed($row->id,$user->id);      
                            $row->is_user_liked = \Helpers::getShortVideoLiked($row->id,$user->id);        
                        }  
                    }
                }
            }
                
            $response = $this->sendResponse($short_videos, __('lang.message_data_retrived_successfully'));  
            return $response;
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }
    
    public function getShortVideoComments(Request $request)
    {
        try{
            $post = $request->all();
            if(isset($post) && !empty($post)){
                $comments = ShortVideoComment::where('short_video_id',$post['short_video_id'])->where('status',1)->where('approval_status',1)->get();
                if(count($comments)){
                    foreach($comments as $comment){         
                        $user = User::select('id','name','photo')->where('id',$comment->user_id)->first();  
                        if($user){
                            if($user->photo!=''){
                                $user->photo = url('uploads/user/'.$user->photo);
                            }
                        } 
                        $comment->user = $user;
                    }
                }
                return $this->sendResponse($comments, __('lang.message_data_retrived_successfully'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }            
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }
    
    public function doShortVideoComment(Request $request)
    {
        try{
            $post = $request->all();

            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){
                $commentArr = array(
                    'user_id'=>$user_id,
                    'short_video_id' => $post['short_video_id'],
                    'comment'=>$post['comment'],
                    'created_at'=>date('Y-m-d H:i:s'),
                );    
                if(setting('is_autoapprove_enable')==1){
                    $commentArr['approval_status'] = 1;
                }                            
                ShortVideoComment::insert($commentArr);
                if(setting('is_autoapprove_enable')==1){
                    $message = __('lang.message_successfully_commented');
                }else{
                    $message = __('lang.message_successfully_commented_and_submitted_for_approval');
                }
                 return $this->sendResponse($commentArr,$message);
                    
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doReportShortVideoComment(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){
                $commentArr = array(
                    'user_id'=>$user_id,
                    'short_video_comment_id' => $post['comment_id'],
                    'created_at'=>date('Y-m-d H:i:s'),
                );                                
                ReportComment::insert($commentArr);
                return $this->sendResponse([],__('lang.message_successfully_reported'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function doDeleteShortVideoComment(Request $request)
    {
        try{
            $post = $request->all();
            $user_id = 0;
            if($request->header('api-token')!=''){
                $user = User::where('api_token',$request->header('api-token'))->first();
                if($user){
                    $user_id = $user->id;
                }                
            } 
            if(isset($post) && !empty($post)){                               
                ShortVideoComment::where('user_id',$user_id)->where('id',$post['id'])->delete();
                return $this->sendResponse([],__('lang.message_comment_deleted_successfully'));
            }else{
                return $this->sendError(__('lang.message_something_went_wrong'));
            }
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }
    
    public function getAppHomePage(Request $request)
    {
        try{            
            $pagination_no = config('constant.api_pagination');
            
            if(isset($search['per_page']) && !empty($search['per_page'])){
                $pagination_no = $search['per_page'];
            }
            $appHomePageData = AppHomePage::where('status',1)->orderBy('order','ASC')->get();
            
            if(count($appHomePageData) > 0){
                foreach($appHomePageData as $eachrow){
                    
                    if($eachrow->visibility_id !='' && $eachrow->visibility_id != 0){
                        $visibility_id = $eachrow->visibility_id;
                        $blog_arr = \Helpers::getPostIdByVisibilityId($visibility_id);
                        
                        $eachrow->blogs = Blog::select('id', 'type', 'title','description', 'source_name', 'source_link','voice', 'accent_code','video_url', 'is_voting_enable', 'schedule_date','created_at', 'updated_at', 'background_image','is_featured')->where('status',1)->whereIn('id',$blog_arr)->where('schedule_date',"<=",date("Y-m-d H:i:s"))->with('blog_category')->with('blog_sub_category')->orderBy('schedule_date','DESC')->paginate($pagination_no)->appends('per_page', $pagination_no);
                        
                        if(count($eachrow->blogs)){
                            foreach($eachrow->blogs as $blog){
                                $blogTranslate = BlogTranslation::where('blog_id',$blog->id)->where('language_code',$this->language)->first();
                                if ($blogTranslate) {
                                    $blog->title = $blogTranslate->title;
                                    $blog->description = $blogTranslate->description;
                                }
                                $category_id = 0;
                                
                                if(isset($blog->blog_category)){
                                    $category_id = $blog->blog_category[0]->category_id;
                                }
                                
                                $blog->category_id = $category_id;
                                $blog->is_feed = false;
                                $blog->is_vote = 0;
                                $blog->is_bookmark = 0;
                                $blog->is_user_viewed = 0; 
                                $blog->is_user_liked = 0; 
                                $blog->like_count = \Helpers::getLikeCount($blog->id);
                                if($request->header('api-token')!=''){
                                    $user = User::where('api_token',$request->header('api-token'))->first();
                                    if($user){
                                        $blog->is_feed = \Helpers::categoryIsInFeed($row->id,$user->id);
                                        $blog->is_vote = \Helpers::getVotes($blog->id,$user->id);              
                                        $blog->is_bookmark = \Helpers::getBookmarks($blog->id,$user->id);              
                                        $blog->is_user_viewed = \Helpers::getViewed($blog->id,$user->id);      
                                        $blog->is_user_liked = \Helpers::getLiked($blog->id,$user->id);        
                                    }  
                                } 
                                                           
                                $blog->visibilities = \Helpers::getVisibilities($blog->id);
                                $blog->question = \Helpers::getQuestionsOptions($blog->id);
                                $blog->images = \Helpers::getBlogImages($blog->id,'768x428');
                                if($blog->background_image!=''){
                                    $blog->background_image = url('uploads/blog/'.$blog->background_image);
                                }
                                
                                $blog->blog_sub_category_ids = $blog->blog_sub_category->pluck('category_id');
                                unset($blog->blog_sub_category);
                                unset($blog->blog_category);
                            }
                        }
                    }
                    
                    if($eachrow->category_id !='' && $eachrow->category_id != 0){
                        
                        $new_category_id = [];
                        
                        $category_id = explode(',', $eachrow->category_id);
                        if(count($category_id)){
                            foreach($category_id as $id){
                                array_push($new_category_id,$id);
                            }
                        }
                        
                        if($eachrow->sub_category_id != ''){
                            $sub_category_id = explode(',', $eachrow->sub_category_id);
                            if(count($sub_category_id)){
                                foreach($sub_category_id as $id){
                                    array_push($new_category_id,$id);
                                }
                            }
                        }
                        $blog_arr = \Helpers::getPostIdByCategoryId($new_category_id);
                        
                        $eachrow->blogs = Blog::select('id', 'type', 'title','description', 'source_name', 'source_link','voice', 'accent_code','video_url', 'is_voting_enable', 'schedule_date','created_at', 'updated_at', 'background_image','is_featured')->where('status',1)->whereIn('id',$blog_arr)->where('schedule_date',"<=",date("Y-m-d H:i:s"))->with('blog_sub_category')->orderBy('schedule_date','DESC')->paginate($pagination_no)->appends('per_page', $pagination_no);
                        
                        if(count($eachrow->blogs)){
                            foreach($eachrow->blogs as $blog){
                                $blogTranslate = BlogTranslation::where('blog_id',$blog->id)->where('language_code',$this->language)->first();
                                if ($blogTranslate) {
                                    $blog->title = $blogTranslate->title;
                                    $blog->description = $blogTranslate->description;
                                }
                                $category_id = 0;
                                
                                if(isset($blog->blog_category)){
                                    $category_id = $blog->blog_category[0]->category_id;
                                }
                                
                                $blog->category_id = $category_id;
                                
                                $blog->is_feed = false;
                                $blog->is_vote = 0;
                                $blog->is_bookmark = 0;
                                $blog->is_user_viewed = 0; 
                                $blog->is_user_liked = 0; 
                                $blog->like_count = \Helpers::getLikeCount($blog->id);
                                if($request->header('api-token')!=''){
                                    $user = User::where('api_token',$request->header('api-token'))->first();
                                    if($user){
                                        $blog->is_feed = \Helpers::categoryIsInFeed($row->id,$user->id);
                                        $blog->is_vote = \Helpers::getVotes($blog->id,$user->id);              
                                        $blog->is_bookmark = \Helpers::getBookmarks($blog->id,$user->id);              
                                        $blog->is_user_viewed = \Helpers::getViewed($blog->id,$user->id);      
                                        $blog->is_user_liked = \Helpers::getLiked($blog->id,$user->id);        
                                    }  
                                } 
                                                           
                                $blog->visibilities = \Helpers::getVisibilities($blog->id);
                                $blog->question = \Helpers::getQuestionsOptions($blog->id);
                                $blog->images = \Helpers::getBlogImages($blog->id,'768x428');
                                if($blog->background_image!=''){
                                    $blog->background_image = url('uploads/blog/'.$blog->background_image);
                                }
                                
                                $blog->blog_sub_category_ids = $blog->blog_sub_category->pluck('category_id');
                                unset($blog->blog_sub_category);
                                unset($blog->blog_category);
                            }
                        }
                    }
                }
            }
            
            
                
            $response = $this->sendResponse($appHomePageData, __('lang.message_data_retrived_successfully'));  
            return $response;
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

}