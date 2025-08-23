<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class ShareController extends Controller
{
  
  public function shareBlog(Request $request)
    {
        $blogId = $request->input('blog_id');
        $blog = Blog::where('id',$blogId)->with('image')->first();
        if(!$blog){
          return 'Invalid Blog Id';  
        }
        
        $isIOS = $request->header('user-agent') && strpos($request->header('user-agent'), 'iPhone') !== false;
        if ($isIOS) {
            $deepLinkUrl = setting('ios_schema') .'/blog/'. $blogId;
        } else {
            $deepLinkUrl = setting('android_schema') .'/blog/'. $blogId;
        }
        if ($isIOS) {
            $fallbackUrl = setting('appstore_url'); 
        } else {
            $fallbackUrl = setting('playstore_url');
        }
        $ogTags = "
            <meta property='og:title' content='{$blog->seo_title}'>
            <meta property='og:description' content='{$blog->seo_description}'>            
            <meta property='og:url' content='{$deepLinkUrl}'>
        ";
      	if (isset($blog->image) && $blog->image != '') {
            $blogImage = $blog->image->image ?? '';

            if ($blogImage != '') {
                $blogImageURL = url('uploads/blog/768x428/' . $blogImage);
                $ogTags .= "<meta property='og:image' content='{$blogImageURL}'>";
              
            }
        }
        $script = "
            <script>
                setTimeout(function() {
                    window.location.href = '$fallbackUrl';
                }, 100); // Redirect to the App Store or Play Store after 10 seconds
                window.location.href = '$deepLinkUrl';
            </script>
        ";
        $htmlContent = "<html><head>{$ogTags}</head><body>{$script}</body></html>";
        return response($htmlContent)->header('Content-Type', 'text/html');
    }
    
}