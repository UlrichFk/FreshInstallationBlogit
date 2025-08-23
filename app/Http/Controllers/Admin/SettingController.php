<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Models\Language;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['result'] = Setting::get();
            // echo json_encode($data['result']);exit;
            $data['is_voice_enabled'] = \Helpers::getValueFromKey('is_voice_enabled');
            $data['voice_type'] = \Helpers::getValueFromKey('voice_type');
            $data['languages'] = Language::where('status',1)->get();
            $data['voice_accent'] = config('constant.voice_accent');
            $data['zones'] = timezone_identifiers_list();
            $data['font_family'] = config('constant.font_family');
            return view('admin/setting.index',$data);
        } 
        catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        try{
            $updated = Setting::updateContent($request->all());
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
     * Set language.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setLanguage(Request $request){
        $post = $request->all();
        if (array_key_exists($post['lang'], Config::get('languages'))) {
            if (isset($post['lang'])) {
                App::setLocale($post['lang']);
                Session::put('admin_locale', $post['lang']);
                setcookie('admin_lang_code',$post['lang'],time()+60*60*24*365);
            }
        }
        return redirect()->back();
    }

    // For S3 connection
    public function testS3Connection(Request $request)
    {
        if ($request->hasFile('s3_test_image')) {
            $file = $request->file('s3_test_image');
            $filePath = 'test-images/' . $file->getClientOriginalName();

            try {
                // Attempt to upload the file to S3
                $uploadSuccess = Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
                
                // Verify if the file was successfully uploaded
                if ($uploadSuccess && Storage::disk('s3')->exists($filePath)) {
                    $imagePath = Storage::disk('s3')->url($filePath);

                    // Update the default storage setting
                    Setting::where('key', 'default_storage')->update(['value' => 's3_storage']);
                    Session::put('imagePath', $imagePath);

                    return response()->json(['image_path' => $imagePath]);
                } else {
                    throw new \Exception('Failed to verify S3 connection.');
                }
            } catch (\Exception $e) {
                // Catch and return any errors that occur
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }


    // For local connection
    public function testLocalConnection(Request $request)
    {
        Session::forget('imagePath');
        try {
            Setting::where('key','default_storage')->update(['value' => 'local_storage']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
