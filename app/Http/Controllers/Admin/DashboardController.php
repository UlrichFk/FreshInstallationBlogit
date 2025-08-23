<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Models\Translation;
use App\Models\Language;
use App\Models\BlogAnalytic;

use App\Models\CmsContent;
use App\Models\CmsContentTranslation;

use Firebase\JWT\JWT;
use Google\Client;
use Google\Service\Drive;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['blog'] = Blog::where('status',1)->where('type','post')->count();
        $data['quote'] = Blog::where('status',1)->where('type','quote')->count();
        $data['category'] = Category::where('status',1)->count();
        $data['user'] = User::where('status',1)->where('type','user')->count();
        $data['most_viewed_blogs'] = Blog::getMostViewedBlogs();
        $data['most_selected_categories'] = Category::getMostSelectedCategories();
        $totalGmailUsers = User::where('type','user')->where('login_from','google')->where('status',1)->count();
        $data['total_gmail'] = ($totalGmailUsers > 0) ? ($data['user'] / $totalGmailUsers) * 100 : 0;
        $totalEmailUsers = User::where('type','user')->where('login_from','email')->where('status',1)->count();
        $data['total_email'] = ($totalEmailUsers > 0) ? ($data['user'] / $totalEmailUsers) * 100 : 0;
        // echo json_encode($data['most_viewed_blogs']);exit;
        Artisan::call('schedule:run');
        
        return view('admin.dashboard.index',$data);
    }

    public function destroyDuplicateEntries()
    {
        try{
            $languageIdToDeleteDuplicates = 1;
            TTranslation::where('language_id', $languageIdToDeleteDuplicates)
            ->groupBy('key')
            ->havingRaw('COUNT(*) > 1')
            ->delete();
        }
        catch(\Exception $ex){
            returnredirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
}
