<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use App\Models\CmsContent; 
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Cms page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {        
        try{         
            return view('site.contact-us.index');    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
}
