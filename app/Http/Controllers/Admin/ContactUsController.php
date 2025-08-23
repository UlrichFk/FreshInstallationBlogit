<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the categories.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    **/
    public function index(Request $request)
    {
        $data['result'] = ContactUs::getLists($request->all());
            return view('admin/contact-us.index',$data);
        // try{
        //     $data['result'] = ContactUs::getLists($request->all());
        //     return view('admin/contact-us.index',$data);
        // }
        // catch(\Exception $ex){
        //     return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        // }
    }

    /**
     * Reply the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
    **/
    public function replyQuery(Request $request)
    {
        try{
            $replied = ContactUs::replyQuery($request->all(),$request->input('id'));
            if($replied['status']==true){
                return redirect()->back()->with('success', $replied['message']); 
            }
            else{
                return redirect()->back()->with('error', $replied['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }
}
