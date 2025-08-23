<?php
use App\Models\Blog;
use App\Models\Category; 
use App\Models\CmsContent; 
use App\Models\User;
use App\Models\BlogVisibility;
use App\Models\UserFeed;
use App\Models\BlogCategory;
use App\Models\BlogQuestion;
use App\Models\BlogQuestionOption;
use App\Models\Vote;
use App\Models\Language;
use App\Models\BlogImage;
use App\Models\BlogBookmark;
use App\Models\BlogAnalytic;
use App\Models\SocialMediaLink;
use App\Models\ShortVideoAnalytic;
use App\Models\ShortVideoComment;
use App\Models\Visibility;
use App\Models\Setting;
use App\Models\AdAnalytic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator;

class Helpers {
    /**
     * Get user language code
    **/
    public static function returnUserLanguageCode() {
        // $language = setting('preferred_site_language');
        $language = "en";

        if (auth()->user() && auth()->user()->type == 'user') {
            if (auth()->user()->lang_code != '') {
                $language = auth()->user()->lang_code;
            }
        }else{
            if(isset($_COOKIE['lang_code']) && $_COOKIE['lang_code'] != '') {
                $language = $_COOKIE['lang_code'];
            }
        }
        return $language;
    }

    /**
     * Create slug 
    **/
    public static function createSlug($title,$in='blog',$whr=0,$alphaNum = false){
        if($alphaNum){
            $slug = Str::slug($title, '-');
        }else{
            $slug = Str::slug($title, '-');
        }
        if($in == 'blog'){            
            $slugExist = Blog::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }else if($in == 'category'){
            $slugExist = Category::where(DB::raw('LOWER(slug)'),strtolower($slug))->where('id','!=',$whr)->get();
        }else if($in == 'cms'){
            $slugExist = CmsContent::where(DB::raw('LOWER(page_title)'),strtolower($slug))->where('id','!=',$whr)->get();
        }
        if(count($slugExist)){
            $slug = Str::slug($title.'-'.Str::random(5).'-'.Str::random(5), '-');
            return $slug;
        }else{
            return $slug;
        }
    }

    /**
     * Upload file
    **/
    public static function uploadFiles($file,$folderName,$type=false) {
        try {
            // echo $type;exit;
            if($type=='video' || $type=='pdf'){
                $fileName = time() . rand() . '.' . $file->extension(); 
                $file->move(public_path('uploads/' . $folderName), $fileName);
            }else{
                $fileName = time() . rand() .'.webp';
                $image = Image::make($file)->encode('webp', 75);
                $image->save(public_path('uploads/'.$folderName.'/'.$fileName));
            }
            
            return ['status' => true, 'message' => config('constant.common.messages.success_image'),'file_name'=>$fileName];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
    
    
    public static function uploadFilesIfFolderNotExists($file, $folderName)
    {
        try {
            $fileName = time() . rand() . '.webp';
            $uploadPath = public_path('uploads/' . $folderName);
    
            // Check if folder exists, if not, create it
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true); // Create folder with recursive permissions
            }
    
            $image = Image::make($file)->encode('webp', 75);
            $image->save($uploadPath . '/' . $fileName);
    
            return [
                'status' => true,
                'message' => config('constant.common.messages.success_image'),
                'file_name' => $fileName
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()
            ];
        }
    }


    /**
     * Upload file
    **/
    public static function uploadAdsFiles($file,$folderName) {
        try {
            $fileName = time() . rand() .'.webp';
            $image = Image::make($file);
            $width = $image->width();
            $height = $image->height();
            $image = $image->encode('webp', 75);
            $image->save(public_path('uploads/'.$folderName.'/'.$fileName));
            $dimensions = $width.'x'.$height;
            return ['status' => true, 'message' => config('constant.common.messages.success_image'),'file_name'=>$fileName,'dimensions'=>$dimensions];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Upload file
    **/
    public static function uploadFilesAfterResizeCompress($file,$folderName) {
        try {
            $fileName = time() . rand() .'.'.$file->extension();
            $image = Image::make($file);
            $image->save(public_path('uploads/'.$folderName.'/original/'.$fileName));
            $image->resize(768, 428) // Resize the image to 768x428 pixels
                ->encode($file->extension(), 75) // Compress the image to 75% quality JPEG
                ->save(public_path('uploads/'.$folderName.'/768x428/'.$fileName));
            $imagesmall = Image::make($file);
            $imagesmall->resize(327, 250) // Resize the image to 327x250 pixels
                ->encode($file->extension(), 75) // Compress the image to 75% quality JPEG
                ->save(public_path('uploads/'.$folderName.'/327x250/'.$fileName));            
            $imageextrasmall = Image::make($file);
            $imageextrasmall->resize(80, 80) // Resize the image to 800x600 pixels
                    ->encode($file->extension(), 75) // Compress the image to 75% quality JPEG
                    ->save(public_path('uploads/'.$folderName.'/80x80/'.$fileName));
            // $file->move(public_path('uploads/'.$folderName), $fileName);
            return ['status' => true, 'message' => config('constant.common.messages.success_image'),'file_name'=>$fileName];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Upload file with original name
    **/
    public static function uploadFilesAfterResizeCompressOriginalName($file,$folderName) {
        try {
            $fileName = $file->getClientOriginalName();
            $imageName = "";
            if($fileName!=''){
                $finalName = "";
                $explodeFileName = explode(".",$fileName);
                if(isset($explodeFileName[0]) && $explodeFileName[0]!=''){
                    $finalName = Str::slug($explodeFileName[0],'-');
                    $checkExist = BlogImage::where('image',$finalName.'.webp')->first();
                    if($checkExist){
                        $finalName = Str::slug($explodeFileName[0].'-'.Str::random(5).'-'.Str::random(5), '-');
                    }
                }
                $imageName = $finalName.'.webp';
            }
            
            if($file->extension()==='gif'){
                $path1 = public_path('uploads/'.$folderName.'/original/');
                $image = $file;
                $image->move($path1, $imageName);

                $sourceFolder = public_path('uploads/'.$folderName.'/original/');
                $sourceFilePath = public_path('uploads/'.$folderName.'/original/'.$imageName);
                $destinationFolders = [
                    '768x428',
                    '327x250',
                    '80x45',
                ];

                foreach ($destinationFolders as $dir) {
                    $destinationFolder = public_path('uploads/'.$folderName.'/'.$dir.'/');
                    if (!file_exists($destinationFolder)) {
                        mkdir($destinationFolder, 0777, true);
                    }

                    $destinationFilePath = $destinationFolder . $imageName;
                    copy($sourceFilePath, $destinationFilePath);
                }                
            }else{
                $image = Image::make($file)->encode('webp', 75);
                $image->save(public_path('uploads/'.$folderName.'/original/'.$imageName));

                $croppedImage = Image::make($file)->fit(768, 428)->encode('webp', 75);
                $croppedImage->save(public_path('uploads/'.$folderName.'/768x428/'.$imageName));

                $imagesmall = Image::make($file)->fit(327, 250)->encode('webp', 75);
                $imagesmall->save(public_path('uploads/'.$folderName.'/327x250/'.$imageName));   

                $imageextrasmall = Image::make($file)->fit(80, 45)->encode('webp', 75);
                $imageextrasmall->save(public_path('uploads/'.$folderName.'/80x45/'.$imageName));
            }            
            return ['status' => true, 'message' => config('constant.common.messages.success_image'),'file_name'=>$imageName];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Upload file
    **/
    public static function uploadFilesThroughUrlAfterResizeCompress($file, $folderName)
    {
        try {
            $ext = self::get_file_extension($file);
            $extensions = ["jpg", "jpeg", "png", "webp", "gif"];
            $imageName = time() . rand() . '.webp';
            $path = public_path('uploads/' . $folderName . '/');
            $image = Image::make($file);

            if (!in_array($ext, $extensions)) {
                $content = file_get_contents($file);
                $originalPath = $path . 'original/' . $imageName;
                file_put_contents($originalPath, $content);
                $image = Image::make($originalPath);
            }

            $image->encode('webp', 75);

            $sizes = [
                ['folder' => '768x428', 'width' => 768, 'height' => 428],
                ['folder' => '327x250', 'width' => 327, 'height' => 250],
                ['folder' => '80x45', 'width' => 80, 'height' => 45],
            ];

            foreach ($sizes as $size) {
                $resizedImage = $image->fit($size['width'], $size['height']);
                $resizedPath = $path . $size['folder'] . '/' . $imageName;
                $resizedImage->save($resizedPath);
            }

            return ['status' => true, 'message' => config('constant.common.messages.success_image'), 'file_name' => $imageName];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile()];
        }
    }


    /**
     * Upload file
    **/
    public static function uploadFilesThroughUrl($file,$folderName) {
        try {
            // $fileName = time() . rand() .'.'.$file->extension();
            $ext = self::get_file_extension($file);
            $fileName = time() . rand() .'.webp';
            $image = Image::make($file)->encode('webp', 75);
            $image->save(public_path('uploads/'.$folderName.'/'.$fileName));
            return ['status' => true, 'message' => config('constant.common.messages.success_image'),'file_name'=>$fileName];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Translate text into particular language through Chat GPT
    **/
    public static function translate($text, $targetLanguage)
    {
        $client = new Client();
        $url = 'https://api.openai.com/v1/completions';
        $apiKey = setting('chat_gpt_api_key');
        $params = [
            "model" => "text-davinci-003",
            'prompt' => "Translate this into ".$targetLanguage." :\n\n\n".$text."\n\n\n",
            "temperature"=> 0.3,
            "max_tokens"=> 100,
        ];
        
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'json' => $params,
        ]);
        
        $body = $response->getBody();
        $decodedBody = json_decode($body, true);
        $generatedText = $decodedBody['choices'][0]['text'];       
        return $generatedText;
    }

    public static function googleTranslation($text, $targetLanguage)
    {
        $apiKey = setting('google_translation_api_key');
    
        $apiUrl = "https://translation.googleapis.com/language/translate/v2?key=$apiKey";
    
        $data = array(
            "q" => [$text],
            "target" => $targetLanguage
        );
    
        $ch = curl_init($apiUrl);
    
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
    
        curl_close($ch);
    
        $result = json_decode($response, true);
        if ($result && isset($result['data']['translations'][0]['translatedText'])) {
            $translation = $result['data']['translations'][0]['translatedText'];
            $response_data = array(
                'status'=>true,
                'data'=>$translation,
                'message'=>__('lang.message_data_translated_successfully')
            );
            return $response_data;
        } else {
            $response_data = array(
                'status'=>false,
                'data'=>[],
                'message'=>"Unexpected response status"
            );
            return $response_data;
        }
    
    }

    /**
     * Get Page Name on the basis of uri segment
    **/
    public static function getPageName($url) {
        // $language = setting('preferred_site_language');
        if ($url == 'site-setting') {
            $title = __('lang.site_settings') ;
        }else if ($url == 'app-setting') {
            $title = __('lang.app_settings');
        }else if ($url == 'global-setting') {
            $title = __('lang.global_settings');
        }else if ($url == 'push-notification-setting') {
            $title = __('lang.push_notification_settings');
        }else if ($url == 'email-setting') {
            $title = __('lang.email_settings');
        }else if ($url == 'maintainance-setting') {
            $title = __('lang.maintainance_settings');
        }else if ($url == 'news-setting') {
            $title = __('lang.news_settings');
        }else if ($url == 'admob-setting') {
            $title = __('lang.admob_settings');
        }else if ($url == 'fb-ads-setting') {
            $title = __('lang.fb_ads_settings');
        }else if ($url == 'social') {
            $title = trans("admin.social");
        }else{
            $title = trans("admin.no_setting");
        }
        return $title;
    }


    /**
     * Check Role has selected that permission
    **/
    public static function checkRoleHasPermission($role_id,$permission_id) {
        // $language = setting('preferred_site_language');
        $permission = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role_id)
            ->where("role_has_permissions.permission_id",$permission_id)->count();
        if ($permission>0) {
           return 1;
        }else{
            return 0;
        }        
    }

    /**
     * get list of news from news api
    **/
    public static function getNewsApiLists($search) {
        $sources = [];
        $sourcesUrl = 'https://newsapi.org/v2/sources';
        $sourcesFields = [
            'apiKey' => setting('news_api_key'),
        ];
        $sourcesUrl = $sourcesUrl . '/?' . http_build_query($sourcesFields);

        $ch = curl_init($sourcesUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'PostmanRuntime/7.26.8',
        ]);
        $sourcesResult = curl_exec($ch);
        curl_close($ch);

        $sourcesResult = json_decode($sourcesResult, true);
        if ($sourcesResult['status'] === 'ok') {
            $sources = $sourcesResult['sources'];
        }

        $data = [];

        // Fetching articles
        if (isset($search['keyword']) && $search['keyword'] !== '') {
            $articlesUrl = 'https://newsapi.org/v2/everything';
            $articlesFields = [
                'q' => $search['keyword'],
                'sortBy' => 'publishedAt',
                'apiKey' => setting('news_api_key'),
            ];

            $optionalFields = ['sources', 'domains', 'language', 'from', 'to'];
            foreach ($optionalFields as $field) {
                if (isset($_GET[$field]) && $_GET[$field] !== '') {
                    $articlesFields[$field] = $_GET[$field];
                }
            }

            $articlesUrl = $articlesUrl . '/?' . http_build_query($articlesFields);
            $ch = curl_init($articlesUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT => 'PostmanRuntime/7.26.8',
            ]);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result, true);
            if ($result['status'] === 'ok') {
                $data = $result['articles'];
            }
        }
        $finalArray = array(
            'data'=>self::arrayPaginator($data,$search),
            'source'=>$sources,
            'news_api_language' =>config('constant.news_api_language')
        );
        return $finalArray;
    }

    public static function arrayPaginator($array, $request)
    {
        $post = $request;
        $per_page_number = config('constant.pagination');
        $page = (isset($post['page']) && !empty($post['page'])) ? $post['page'] : 1;
        $perPage = (isset($post['perpage']))?$post['perpage']:$per_page_number;
        $offset = ($page * $perPage) - $perPage;
        $sliceArray = array_slice($array, $offset, $perPage, true);
        $finalArray = array();
        foreach ($sliceArray as $row) {
            array_push($finalArray, $row);
        }

        return new LengthAwarePaginator($finalArray, count($array), $perPage, $page,['path' => $request->url(), 'query' => $request->query()]);
    }

    public static function get_file_extension($file_name) {
        return substr(strrchr($file_name,'.'),1);
    }

    public static function generateApiToken(){
        mt_srand((double)microtime()*10000);
        $uuid = rand(1,99999).time();
        $salt = substr(sha1(uniqid(mt_rand(), true)), 0, 40);
        return substr(sha1($salt) . $salt,1,85).$uuid;
    }

    public static function validateAuthToken($token){
        $tokenExist  = User::where('api_token',$token)->first();
        if($tokenExist){
            return $tokenExist;
        }
        return false;
    }

    public static function getBlogsArrOnTheBasisOfCategory($category_id){
        $blog_arr = array();
        $getBlogs = BlogCategory::where('category_id',$category_id)->get();
        if(count($getBlogs)){
            foreach($getBlogs as $getBlogs_data){
                array_push($blog_arr,$getBlogs_data->blog_id);
            }
        }
        return $blog_arr;
    }

    public static function categoryIsInFeed($category_id,$user_id){
        $is_feed = false;
        $getFeed = UserFeed::where('category_id',$category_id)->where('user_id',$user_id)->first();
        if($getFeed){
            $is_feed = true;
        }
        return $is_feed;
    }

    public static function getVotes($blog_id,$user_id){
        $is_vote = 0;
        $getVote = Vote::where('blog_id',$blog_id)->where('user_id',$user_id)->first();
        if($getVote){
            $is_vote = $getVote->option_id;
        }
        return $is_vote;
    }

    public static function getBookmarks($blog_id,$user_id){
        $is_bookmark = 0;
        $getData = BlogBookmark::where('blog_id',$blog_id)->where('user_id',$user_id)->first();
        if($getData){
            $is_bookmark = 1;
        }
        return $is_bookmark;
    }

    public static function getViewed($blog_id,$user_id){
        $is_viewed = 0;
        $getData = BlogAnalytic::where('type','view')->where('blog_id',$blog_id)->where('user_id',$user_id)->first();
        if($getData){
            $is_viewed = 1;
        }
        return $is_viewed;
    }

    public static function getLiked($blog_id,$user_id){
        $is_liked = 0;
        $getData = BlogAnalytic::where('type','like')->where('blog_id',$blog_id)->where('user_id',$user_id)->first();
        if($getData){
            $is_liked = 1;
        }
        return $is_liked;
    }

    public static function getLikeCount($blog_id){
        $getData = BlogAnalytic::where('type','like')->where('blog_id',$blog_id)->where('user_id','!=',0)->count();
        return $getData;
    }
    
    public static function getShortVideoLikeCount($short_video_id){
        $getData = ShortVideoAnalytic::where('type','like')->where('short_video_id',$short_video_id)->where('user_id','!=',0)->count();
        return $getData;
    }
    
    public static function getShortVideoCommentCount($short_video_id){
        $getData = ShortVideoComment::where('short_video_id',$short_video_id)->where('user_id','!=',0)->count();
        return $getData;
    }
    
    
    public static function getShortVideoViewed($short_video_id,$user_id){
        $is_viewed = 0;
        $getData = ShortVideoAnalytic::where('type','view')->where('short_video_id',$short_video_id)->where('user_id',$user_id)->first();
        if($getData){
            $is_viewed = 1;
        }
        return $is_viewed;
    }
    
    
    public static function getShortVideoLiked($short_video_id,$user_id){
        $is_liked = 0;
        $getData = ShortVideoAnalytic::where('type','like')->where('short_video_id',$short_video_id)->where('user_id',$user_id)->first();
        if($getData){
            $is_liked = 1;
        }
        return $is_liked;
    }
    
    
        public static function getParticularUserViewCount($user_id,$ad_id){

        $getViewCount = AdAnalytic::where('user_id',$user_id)->where('ad_id',$ad_id)->where('type','view')->groupBy('user_id')->count();
        
        return $getViewCount;
    }
    
    public static function getParticularUserBlogViewCount($user_id,$blog_id){

        $getViewCount = BlogAnalytic::where('user_id',$user_id)->where('blog_id',$blog_id)->where('type','view')->count();
        
        return $getViewCount;
    }
    
    public static function getParticularUserAdViewCount($user_id,$ad_id){

        $getViewCount = AdAnalytic::where('user_id',$user_id)->where('ad_id',$ad_id)->where('type','view')->count();
        
        return $getViewCount;
    }
    
    public static function getParticularUserAdClickCount($user_id,$ad_id){

        $getClickCount = AdAnalytic::where('user_id',$user_id)->where('ad_id',$ad_id)->where('type','click')->count();
        
        return $getClickCount;
    }
    
    public static function getParticularUserShortVideoViewCount($user_id,$short_video_id){

        $getViewCount = ShortVideoAnalytic::where('user_id',$user_id)->where('short_video_id',$short_video_id)->where('type','view')->count();
        
        return $getViewCount;
    }

    public static function getVisibilities($blog_id){
        $visibility_arr = array();
        $getVisibility = BlogVisibility::select('visibility_id')->where('blog_id',$blog_id)->get();
        if(count($getVisibility)){
            foreach($getVisibility as $getVisibility_data){
                array_push($visibility_arr,$getVisibility_data->visibility_id);
            }
        }
        return $visibility_arr;
    }

    public static function getQuestionsOptions($blog_id){
        $getQuestions = BlogQuestion::where('blog_id',$blog_id)->first();
        if($getQuestions){
            $getQuestions->options = BlogQuestionOption::where('blog_pool_question_id',$getQuestions->id)->get();            
            if (count($getQuestions->options)) {
                $totalVotes = Vote::where('blog_id', $blog_id)->count();        
                foreach ($getQuestions->options as $getOptions_data) {
                    $optionVotes = Vote::where('blog_id', $blog_id)->where('option_id', $getOptions_data->id)->count();                    
                    if ($totalVotes > 0) {
                        $getOptions_data->percentage = ($optionVotes / $totalVotes) * 100;
                    } else {
                        $getOptions_data->percentage = 0.0;
                    }
                }
            }          
        }
        return $getQuestions;
    }

    public static function getBlogImages($blog_id,$folderName){
        $blog_image_arr = array();
        $blog_images = BlogImage::where('blog_id',$blog_id)->get();
        if(count($blog_images)){
            foreach($blog_images as $images){
                $images->image = url('uploads/blog/'.$folderName.'/'.$images->image);
                array_push($blog_image_arr,$images->image);
            }
        }
        return $blog_image_arr;
    }

    public static function getAllLangList(){
        $list  = Language::where('status',1)->get();
        return $list;
    }

    public static function sendNotification($title, $description, $image, $blog, $player_id)
    {
        $buttons = [];
        $cleanedDescription = strip_tags($description);
        $cleanedDescription = mb_substr($cleanedDescription, 0, 100, 'UTF-8');
        $content = array(
            "en" => $cleanedDescription
        );
        $headings = array(
            "en" => $title
        );
        if($blog){
            if($blog->type=='post'){
                $buttons = [
                    [
                        'id' => __('lang.admin_share'),
                        'text' => __('lang.admin_share'),
                        'icon' => __('lang.admin_share'),
                    ],
                    [
                        'id' => __('lang.admin_bookmark'),
                        'text' => __('lang.admin_bookmark'),
                        'icon' => __('lang.admin_bookmark'),
                    ],
                ];
            }else{
                $buttons = [
                    [
                        'id' => __('lang.admin_share'),
                        'text' => __('lang.admin_share'),
                        'icon' => __('lang.admin_share'),
                    ],
                ];
            }
        }
        
        $icon = url('uploads/setting/'.setting('app_logo'));
        if($blog!=''){
            $dataArr = array("blog"=>$blog->id,"title" => $title);
        }else{
            $dataArr = array("title" => $title);
        }
        $fields = array(
            'app_id' => setting('one_signal_app_id'),
            // 'include_player_ids' => $player_id,
            "included_segments" => ["Subscribed Users"],
            'data' => $dataArr,
            'big_picture' => $image,
            'contents' => $content,
            'headings' => $headings,
            'buttons' => $buttons,
            'icon' => $icon
        );
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.setting('one_signal_key')));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpStatus;
    }


    /**
     * function for send email
     */
    public static function sendEmail($template, $data, $toEmail, $toName, $subject, $fromName = '', $fromEmail = '',$attachment = '') {
        if ($fromEmail != '') {
            $fromEmail = setting('username');
        }else{
            $fromName = setting('site_name');
        }
        try {
            $data = \Mail::send($template, $data, function ($message) use($toEmail, $toName, $subject, $data, $fromName, $fromEmail, $attachment) {
                $message->to($toEmail, $toName);
                $message->subject($subject);
                if ($fromEmail != '' && $fromName != '') {
                    $message->from($fromEmail, $fromName);
                }
                if($attachment != ''){
                    $message->attach($attachment);
                }
            });
            return 1;
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * function to get video id from youtube url
     */
    public static function getVideoIdFromYoutubeUrl($youtube_url) {
        // Regular expression pattern to extract video ID from URL
        $pattern = '/(?<=v=|v\/|embed\/|youtu.be\/|\/v\/|watch\?v=|ytscreeningroom\?v=|embed\/|watch\?feature=player_embedded&v=|%2Fvideos%2F|youtu.be%2F|v%2F)[^#\&\?]*/';
    
        // Use preg_match to find the video ID
        if (preg_match($pattern, $youtube_url, $matches)) {
            return $matches[0];
        } else {
            return null;
        }
    }

    /**
     * function to get video id from youtube url
     */
    public static function getUserOnTheBasisOfDate() {
        $dates = [];
        $users = [];
        if(isset($_GET['date_range'])){
            $date = explode("to",$_GET['date_range']);
            $startDate = (isset($date[0]))?date("Y-m-d",strtotime(trim($date[0]))):date("Y-m-01");
            $endDate = (isset($date[1]))?date("Y-m-d",strtotime(trim($date[1]))):date("Y-m-01");
        }else{
            $startDate = date("Y-m-01");
            $endDate  = date("Y-m-d");
        }
        // $startDate = strtotime('-12 days', strtotime('today'));
        // $endDate = strtotime('today');
    
        $i = 0;
        $currentDate = $startDate;
        // echo json_encode($startDate);echo json_encode($endDate);exit;
        while($currentDate<$endDate){
            array_push($dates, date('Y-m-d', strtotime('+' . $i . ' day', strtotime($startDate))));
            $currentDate = date('Y-m-d', strtotime('+' . $i . ' day', strtotime($startDate)));
            $i++;
        }
    
        foreach ($dates as $date) {
            $userCount = User::where('type','user')->whereDate('created_at', $date)->count();
            array_push($users, $userCount);
        }
        $maxUserCount = 0;
        if(count($users)){
            $maxUserCount = max($users);
        }
        $final = [
            'dates' => $dates,
            'users' => $users,
            'highest_count' => $maxUserCount,
            'chart_start_date' => $startDate,
            'chart_end_date' => $endDate,
        ];
        return $final;
    }

    public static function getSignupOnTheBasisOftype() {
        $dates = ['other','google','email','no_user'];
        $users = [];
        $totalUsers = User::where('type','user')->where('status',1)->count();
        foreach ($dates as $date) {
            if($date!='no_user'){
                $userCount = User::where('type','user')->where('login_from', $date)->count();
                $percentage = ($totalUsers > 0) ? ($userCount / $totalUsers) * 100 : 0;
                array_push($users, $percentage);
            }else{
                if($totalUsers==0){
                    array_push($users, 100);
                }else{
                    array_push($users, 0);
                }
            }
        }    
        $final = [
            'types' => $dates,
            'users' => $users,
        ];
        
        return $final;
    }

    public static function isValidRssUrl($url) {
        try {
            $response = Http::get($url);
            // echo json_encode($response);exit;
            if ($response->successful()) {
                
                $rssContent = $response->body();
                libxml_use_internal_errors(true);
                $xml = simplexml_load_string($rssContent);

                if ($xml !== false) {
                    return true; // Valid XML data
                }
                
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getValueFromKey($key){
        $value = "";
        $setting = Setting::where('key',$key)->first();
        if($setting){
            $value = $setting->value;
        }
        return $value;
    }

    public static function getLimiteCMSdDescriptionAdmin($description){
        $maxCharacters = 200;
        if (strlen($description) > $maxCharacters) {
            $shortenedDescription = substr($description, 0, $maxCharacters - 3) . "...";
        } else {
            $shortenedDescription = $description;
        }

        return $shortenedDescription;
    }

    /*** Site helpers */
    public static function getLimitedDescription($description){
        $maxCharacters = 135;

        // Check if the description contains an iframe
        if (strpos($description, '<iframe') !== false) {
            // Split the description into parts before and after the iframe
            $parts = explode('<iframe', $description);
            $textPart = $parts[0]; // Text before the iframe

            // Check the length of the text part
            if (strlen(strip_tags($textPart)) > $maxCharacters) {
                // If text part is greater than the limit, return truncated text
                $shortenedDescription = substr($textPart, 0, $maxCharacters - 3) . "...";
            } else {
                // Otherwise, do not display the description
                $shortenedDescription = '';
            }
        } else {
            // If there is no iframe, return the description as usual
            if (strlen(strip_tags($description)) > $maxCharacters) {
                $shortenedDescription = substr(strip_tags($description), 0, $maxCharacters - 3) . "...";
            } else {
                $shortenedDescription = $description;
            }
        }

        return $shortenedDescription;
    }


    public static function getCategoryForSite($limit){
        if($limit==0){
            $categories = Category::where('parent_id',0)->where('status',1)->where('is_featured',1)->get();
        }else{
            $categories = Category::where('parent_id',0)->where('status',1)->where('is_featured',1)->limit($limit)->get();
        }        
        if(count($categories)){
            foreach($categories as $category){
                $category->sub_category = Category::where('parent_id',$category->id)->where('status',1)->get();
            }
        }
        return $categories;
    }

    public static function getPopularPosts($limit){
        $blogs = Blog::getPopularPost($limit);
        return $blogs;
    }

    public static function getTrendingPosts($limit){
        $blogs = Blog::getTrendingPost($limit);
        return $blogs;
    }

    public static function getSocialMedias($limit){
        if($limit==0){
            $social = SocialMediaLink::where('status',1)->get();
        }else{
            $social = SocialMediaLink::where('status',1)->limit($limit)->get();
        }   
        return $social;
    }

    public static function showSiteDateFormat($date){
        $date = date('M d, Y',strtotime($date));
        return $date;
    }

    public static function getBlogCategories($blog_id,$page_type,$category_id,$limit=false){
        $blogCategories = array();
        $blogCheckCategories = array();
        $finalCat = "";
        if($page_type == "category" || $page_type == "subcategory"){
            $categories_single = BlogCategory::where('blog_id',$blog_id)->where('category_id',$category_id)->with('category')->latest('created_at')->first();
            if($categories_single){
                $finalCat = $categories_single;
            }
        }else{
            $categories = BlogCategory::where('blog_id',$blog_id)->where('type','subcategory')->with('category')->get();
            if(count($categories)){
                foreach($categories as $blog_categories){
                    if(isset($blog_categories->category) && $blog_categories->category!=''){
                        if(!in_array($blog_categories->category->parent_id,$blogCheckCategories)){
                            array_push($blogCheckCategories,$blog_categories->category->parent_id);
                        }
                    }
                    if(count($blogCategories)<2){
                        array_push($blogCategories,$blog_categories);
                    }     
                    if(count($blogCategories)<2 && count($blogCheckCategories)){ 
                        $getCategorydata = BlogCategory::where('blog_id',$blog_id)->whereNotIn('category_id',$blogCheckCategories)->where('type','category')->with('category')->get();
                        if(count($getCategorydata)){
                            foreach($getCategorydata as $getCategorydata_data){
                                if(!in_array($getCategorydata_data->category_id,$blogCheckCategories)){
                                    array_push($blogCategories,$getCategorydata_data);
                                } 
                            }
                        }                                
                    }
                }
            }else{
                $getCategorydata = BlogCategory::where('blog_id',$blog_id)->whereNotIn('category_id',$blogCheckCategories)->where('type','category')->with('category')->get();
                if(count($getCategorydata)){
                    foreach($getCategorydata as $getCategorydata_data){
                        if(count($blogCategories)<2){ 
                            array_push($blogCategories,$getCategorydata_data);
                        }
                    }
                }    
            }
            if($page_type=='detail'){
                $finalCat = $blogCategories;
            }else{
                if(count($blogCategories)){
                    $finalCat = $blogCategories[0];
                } 
            }              
        }
        
        return $finalCat;
    }

    public static function getLimitedTitleSlider($title){
        $maxCharacters = 30;
        if (strlen($title) > $maxCharacters) {
            $shortenedTitle = substr($title, 0, $maxCharacters - 3) . "...";
        } else {
            $shortenedTitle = $title;
        }

        return $shortenedTitle;
    }
    
    public static function getLimitedTitle($title){
        $maxCharacters = 45;
        if (strlen($title) > $maxCharacters) {
            $shortenedTitle = substr($title, 0, $maxCharacters - 3) . "...";
        } else {
            $shortenedTitle = $title;
        }

        return $shortenedTitle;
    }

    public static function getLimitedTitleForSideContent($title){
        $maxCharacters = 50;
        if (strlen($title) > $maxCharacters) {
            $shortenedTitle = substr($title, 0, $maxCharacters - 3) . "...";
        } else {
            $shortenedTitle = $title;
        }

        return $shortenedTitle;
    }

    public static function getCmsForSite(){
        $cms = CmsContent::where('status',1)->get();
        return $cms;
    }

    public static function getParticularBlogPollQuestionOptions($blog_id) {
        $question = '';
        $BlogQuestionOptionArr = '';
        $getBlogQuestion = BlogQuestion::where('blog_id',$blog_id)->first();

        if($getBlogQuestion->question){

            $question_id = $getBlogQuestion->id;
            $BlogQuestionOption = BlogQuestionOption::where('blog_pool_question_id',$question_id)->get();
            if(count($BlogQuestionOption)){
                $BlogQuestionOptionArr = $BlogQuestionOption;
                return $BlogQuestionOptionArr;
            }else{
                  $BlogQuestionOptionArr = [];
            }

        }else{
             $question = [];
        }

        return $question;

    }

    public static function getParticularBlogQuestion($blog_id){
        $question = '';
        $getBlogQuestion = BlogQuestion::where('blog_id',$blog_id)->first();
        if($getBlogQuestion->question){
            $question = $getBlogQuestion->question;
        }else{
             $question = '--';
        }
        return $question;
    }
    
    // for convert key
    public static function maskApiKey($key) {
        if($key && strlen($key) >= 5){
            return str_repeat('*', strlen($key) - 5) . substr($key, -5);
        }else{
            return '';
        }
    }
    
    // for get version
    public static function getVersion($filePath)
    {
        return json_decode(file_get_contents($filePath), true)['version'];
    }
    
    // for get language direction
    public static function getLanguageDirection($langCode)
    {
         $lang = Language::where('code',$langCode)->first();
        if($lang){
         $direction = $lang->position;
        }else{
         $direction = 'ltr';
        }
        return $direction;
    }
    
    
    public static function getTypeDataOfCategoryAppHomePage($category_id,$sub_category_id){
        $categoriesData = [];
        if($category_id !=''){
            $category_id = explode(',', $category_id);
            $sub_category_id = explode(',', $sub_category_id);
            $new_Array = array_merge($category_id,$sub_category_id);
            $categoriesData = Category::whereIn('id',$new_Array)->pluck('name')->toArray();
        }
        return $categoriesData;
    }
    
    public static function getTypeDataOfVisibilityAppHomePage($visibility_id){
        $display_name = '--';
        $data = Visibility::where('id',$visibility_id)->first();
        if($data){
            $display_name = $data->display_name;
        }
        return $display_name;
    }
    
    
    public static function getPostIdByVisibilityId($visibility_id){
        $blog_ids_arr = array();
        $getVisibility = BlogVisibility::select('blog_id')->where('visibility_id',$visibility_id)->get();
        if(count($getVisibility)){
            foreach($getVisibility as $getVisibility_data){
                array_push($blog_ids_arr,$getVisibility_data->blog_id);
            }
        }
        return $blog_ids_arr;
    }
    
    
    public static function getPostIdByCategoryId($new_category_id){
        $blog_ids_arr = array();
        $getData = BlogCategory::select('blog_id')->whereIn('category_id',$new_category_id)->get();
        if(count($getData)){
            foreach($getData as $data){
                array_push($blog_ids_arr,$data->blog_id);
            }
        }
        return $blog_ids_arr;
    }

    public static function getNextPreviousLimitedTitle($title){
        $maxCharacters = 85;
        if (strlen($title) > $maxCharacters) {
            $shortenedTitle = substr($title, 0, $maxCharacters - 3) . "...";
        } else {
            $shortenedTitle = $title;
        }

        return $shortenedTitle;
    }
    
}
?>