<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\BlogBookmark;
use App\Models\BlogAnalytic;
use Auth;

class SiteController extends Controller
{
    /**
     * Display home page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {        
        try{
            $data['slider'] = Blog::getSliderPost($request->all());
            $data['trending'] = Blog::getTrendingPost($request->all());
            $data['latest'] = Blog::getLatestPost($request->all());
            $total_blogs = $data['latest']->total();
            $data['show_pagination'] = 0;
            if($total_blogs > count($data['latest'])){
                $data['show_pagination'] = 1;
            }
            return view('site.home.home_1',$data);     
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Display Blogs List page as per category.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function blog(Request $request,$category_slug)
    {  
        try{    
            $data['category'] = Category::where('slug',$category_slug)->first();  
            if(!$data['category']){
                return redirect('404_not_found');
            } 
            $data['sub_category'] = Category::where('parent_id',$data['category']->id)->get();
            $data['result'] = Blog::getBlogAsPerCategory($data['category']->id);  
            $total_blogs = $data['result']->total();
            $data['show_pagination'] = 0;
            if($total_blogs > count($data['result'])){
                $data['show_pagination'] = 1;
            }
            return view('site.blog.index',$data);       
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Display Blogs List page as per sub category.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function blogSubCatgory(Request $request,$category_slug,$sub_category_slug)
    {        
        try{ 
            $data['category'] = Category::where('slug',$sub_category_slug)->first();  
            if(!$data['category']){
                return redirect('404_not_found');
            }
            $data['main_category'] = Category::where('id',$data['category']->parent_id)->first();
            $data['sub_category'] = Category::where('parent_id',$data['category']->parent_id)->get();
            $data['result'] = Blog::getBlogAsPerSubCategory($data['category']->id);  
            $total_blogs = $data['result']->total();
            $data['show_pagination'] = 0;
            if($total_blogs > count($data['result'])){
                $data['show_pagination'] = 1;
            }    
            return view('site.blog.index',$data);     
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Display Blog detail page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function detail(Request $request,$slug)
    {   
        try{ 
            $data['row'] = Blog::getBlogDetail($slug);
            if(!$data['row']){
                return redirect('404_not_found');
            }
            $type="";
            $category_id=0;
            if(isset($_GET['type']) && $_GET['type']!=''){
                $type=$_GET['type'];
            }
            if(isset($_GET['id']) && $_GET['id']!=''){
                $category_id=$_GET['id'];
            }

            $data['comments'] = Comment::where('blog_id',$data['row']->id)->with('user')->get();
            $data['recent_articles'] = Blog::getRecentArticles($data['row']->id,$type,$category_id);

            $nextPreviousBlogs = Blog::getNextBlog($data['row']->id,$type,$category_id);
            $data['next_blog'] = $nextPreviousBlogs['nextBlog'];
            $data['previous_blog'] = $nextPreviousBlogs['previousBlog'];

            // Storing the post analytics
            
            $user_id = 0;
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }
            
            if($data['row']){
                $analyticsArr = array(
                    'type'=> 'view',
                    'user_id'=> $user_id,
                    'blog_id' => $data['row']->id,
                    'created_at'=>date('Y-m-d H:i:s'),
                );                                
                BlogAnalytic::insert($analyticsArr);
            }

            return view('site.blog-detail.index',$data);     
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Display All Blogs List page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function allBlogs(Request $request)
    {  
        try{
            $data['result'] = Blog::getAllBlogs($request->all()); 
            $total_blogs = $data['result']->total();
            $data['show_pagination'] = 0;
            if($total_blogs > count($data['result'])){
                $data['show_pagination'] = 1;
            }
            return view('site.blog.all_blogs',$data);       
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

     /**
     * Display Search Blogs List page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function searchBlogs(Request $request)
    {  
        try{
            $data['result'] = Blog::getAllBlogs($request->all());   
            $total_blogs = $data['result']->total();
            $data['show_pagination'] = 0;
            if($total_blogs > count($data['result'])){
                $data['show_pagination'] = 1;
            }
            return view('site.blog.search_blogs',$data);                   
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Display Search Blogs List page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function savedStories(Request $request)
    {  
        try{
            $post = $request->all();
            $bookmarkArr = array();
            $data['bookmark'] = BlogBookmark::where('user_id',Auth::user()->id)->get();  
            if(count($data['bookmark'])){
                foreach($data['bookmark'] as $bookmark){
                    if(!in_array($bookmark->blog_id,$bookmarkArr)){
                        array_push($bookmarkArr,$bookmark->blog_id);
                    }
                }
            }
            $post['blog_id'] = $bookmarkArr;
            $data['bookmarkArr'] = $bookmarkArr;
            $data['result'] = Blog::getAllBookmarks($post);   
            return view('site.blog.saved_blogs',$data);  
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    public function submitComment(Request $request)
    {  
        try{ 
            $add = Comment::addComment($request->all());
            if($add['status']==true){
                return redirect()->back()->with('success', $add['message']); 
            }
            else{
                return redirect()->back()->with('error', $add['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the translation of specified category in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
    **/
    public function addRemoveBookmark(Request $request)
    {
        $post = $request->all();
        $bookmark = BlogBookmark::where('blog_id',$post['blog_id'])->where('user_id',Auth::user()->id)->first();
        if($bookmark){
            BlogBookmark::where('id',$bookmark->id)->delete();
            $data['type'] = "remove";
        }else{
            $bookmarkArr = array(
                'blog_id'=>$post['blog_id'],
                'user_id'=>Auth::user()->id,
                'created_at'=>date('Y-m-d h:i:s')
            );
            BlogBookmark::insertGetId($bookmarkArr);
            $data['type'] = "add";
        }
        $response = [
            'status' => true,
            'message' => "Data updated successfully.",
            'data' => $data
        ];
        return response($response);
    }

    public function fetch(Request $request)
    {
        $post = $request->all();
        if($post['page_name']=='home'){
            $posts = Blog::getLatestPost($request->all());
        }else if($post['page_name']=='category'){
            $category = Category::where('slug',$post['category'])->first(); 
            $posts = Blog::getBlogAsPerCategory($category->id);
        }else if($post['page_name']=='subcategory'){
            $category = Category::where('slug',$post['category'])->first(); 
            $posts = Blog::Blog::getBlogAsPerSubCategory($category->id);  
        }else if($post['page_name']=='allblogs'){
            $posts = Blog::getAllBlogs($request->all());
        }        
        $html = view('site.home.partials.blog_list')->with(array('result'=>$posts))->render();
        return response()->json(['html' => $html,'posts'=>$posts]);
    }
}
