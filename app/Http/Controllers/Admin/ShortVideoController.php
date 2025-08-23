<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortVideo;
use App\Models\ShortVideoAnalytic;
use App\Models\ShortVideoTranslation;
use App\Models\ShortVideoComment;
use App\Models\ReportComment;
use DB;

class ShortVideoController extends Controller
{
    /**
     * Display a listing of the blog.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $data['result'] = ShortVideo::getLists($request->all());

            return view('admin.short_video.index',$data);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.short_video.create');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
            $added = ShortVideo::addUpdate($request->all());
            if($added['status']==true){
                return redirect('admin/short-video')->with('success', $added['message']); 
            }
            else{
                return redirect()->back()->with('error', $added['message']);
            } 
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  type $type, id  $id 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        try {
            $data['row'] = ShortVideo::getDetail($id);
           
            return view('admin.short_video.edit',$data);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $updated = ShortVideo::addUpdate($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect('admin/short-video')->with('success', $updated['message']);
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    


    /**
     * Remove the specified resource from Blog.
     * @param  Request $request
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try{
            $deleted = ShortVideo::deleteRecord($id);
            if($deleted['status']==true){
                return redirect()->back()->with('success', $deleted['message']); 
            }
            else{
                return redirect()->back()->with('error', $deleted['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    
    
    /**
     * Remove the specified category from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateColumn($id,$status)
    {
        try{
            $updated = ShortVideo::changeStatus($status,$id);
            if($updated['status']){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    
    /**
     * Get translations of specified category from storage.
     *
     * @param  id $id
     * @return \Illuminate\Http\Response
    **/
    public function translation($id)
    {
        try{
            $data['detail'] = ShortVideo::getDetail($id);
            $data['languages'] = ShortVideo::getTranslation($id);

            return view('admin/short_video.translation',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Update the translation of specified category in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogTranslationRequest  $request
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateTranslation(Request $request,$id)
    {
        $translationUpdated = ShortVideo::updateTranslation($request->all(),$id);
        if($translationUpdated['status']==true){
            return redirect('admin/short-video')->with('success', $translationUpdated['message']); 
        }
        else{
            return redirect()->back()->with('error', $translationUpdated['message']);
        } 
    }
    
    
    // Analytics
    public function analytics(Request $request,$id)
    {
        try{
            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');
            $data['shares'] = ShortVideoAnalytic::where('type','share')->where('short_video_id',$id)->with('user')->paginate($pagination)->appends('perpage', $pagination);
            $data['totalShortVideoViewsCount'] = ShortVideoAnalytic::where('type','view')->where('short_video_id',$id)->count();
            $data['totalGuestShortVideoViewsCount'] = ShortVideoAnalytic::where('type','view')->where('short_video_id',$id)->where('user_id',0)->count();
            $data['likes'] = ShortVideoAnalytic::where('type','like')->where('short_video_id',$id)->with('user')->paginate($pagination)->appends('perpage', $pagination);
            $data['comments'] = ShortVideoComment::where('short_video_id',$id)->with('user')->get();
            if(count($data['comments'])){
                foreach($data['comments'] as $comment){
                    $comment->reported_count = ReportComment::where('short_video_comment_id',$comment->id)->count();
                }
            }
            
            $data['commentsCount'] = ShortVideoComment::where('short_video_id',$id)->count();
            $data['likesCount'] = ShortVideoAnalytic::where('type','like')->where('short_video_id',$id)->count();
            
            // Fetch views and remove duplicates based on user_id or player_id
            $data['uniqueViewsCount'] = ShortVideoAnalytic::where('type', 'view')
                ->where('short_video_id', $id)
                ->where('user_id','!=',0)
                ->with('user')
                ->get()
                ->unique(function ($item) {
                    return $item['user_id'] == 0 ? $item['fcm_token'] : $item['user_id'];
                });
                
            
            // New one for view analytics
            $checkFcmTokenArr = [];
            $checkUserIdArr = [];
            $finalIds = [];
            $views = ShortVideoAnalytic::where('type','view')->where('short_video_id',$id)->where('user_id','!=',0)->orderBy('id','DESC')->get();
            if(count($views) > 0){
                foreach($views as $view){
                    if(in_array($view->fcm_token, $checkFcmTokenArr)){
                        continue;
                    }
    
                    if(in_array($view->user_id, $checkUserIdArr)){
                        continue;
                    }
    
                    if($view->user_id == 0 && $view->fcm_token !=''){
                        array_push($checkFcmTokenArr, $view->fcm_token);
                    }
    
                    if($view->user_id != 0){
                        array_push($checkUserIdArr, $view->user_id);
                    }
                    
                    array_push($finalIds,$view->id);
                }
            }
            
            $data['views'] = ShortVideoAnalytic::where('type','view')->where('short_video_id',$id)->whereIn('id',$finalIds)->with('user')->orderBy('id','DESC')->paginate($pagination)->appends('perpage', $pagination);
            
            return view('admin.short_video.analytics',$data);
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateShortVideoComment(Request $request)
    {
        try{
            $updated = ShortVideoComment::updateComment($request->all(),$request->input('id'));
            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
    

    /**
     * Remove the specified comment from storage.
     *
     * @param  id  $id
     * @return \Illuminate\Http\Response
    **/
    public function updateShortVideoColumn($id,$name,$value)
    {
        try{
            $updated = ShortVideoComment::updateColumn($id,$name,$value);
            if($updated['status']==true){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    public function deleteSelected(Request $request)
    {
        $selectedIdsString = $request->input('selectedIds');
        
        $selectedIds = explode(',', $selectedIdsString);

        // Delete
        ShortVideo::whereIn('id', $selectedIds)->delete();

        return redirect()->back()->with('success', __('lang.message_bulk_short_video_delete_successfully'));
    }

}