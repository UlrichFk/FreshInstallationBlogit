<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SiteAuthController extends Controller
{
    /**
     * Login page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {        
        try{           
            return view('site.login.index');    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Handle an authentication attempt of front end.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */
    public function doLogin(Request $request)
    {   
        $login = User::userLogin($request->all());
        if($login['status']==true){
            return redirect()->intended('/profile')->with('success',$login['message']);
        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $login['message']);
        }   
    }

    /**
     * Signup page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function signup(Request $request)
    {        
        try{           
            return view('site.signup.index');    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Handle an authentication attempt of front end.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */
    public function doSignup(Request $request)
    {   
        $login = User::userSignup($request->all());
        if($login['status']==true){
            return redirect()->intended('/profile')->with('success',$login['message']);
        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $login['message']);
        }   
    }

    /**
     * Forget password page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function forgetPassword(Request $request)
    {        
        try{           
            return view('site.forget-password.index');    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }


    /**
     * Handle an authentication attempt of front end.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */
    public function doForgetPassword(Request $request)
    {   
        $user = User::userForgetPassword($request->all());
        if($user['status']==true){
            return redirect()->intended('reset-password')->with('success',$user['message']);
        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $user['message']);
        }   
    }

    /**
     * Reset password page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function resetPassword(Request $request)
    {        
        try{           
            return view('site.reset-password.index');    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Handle an authentication attempt of front end.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */
    public function doResetPassword(Request $request)
    {   
        $data = User::userResetPassword($request->all());
        if($data['status']==true){
            return redirect()->intended('login')->with('success',$data['message']);
        }
        else{
            return redirect()->back()->withInput($request->only('email'))->with('error', $data['message']);
        }
    }

    /**
     * Profile page.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function profile(Request $request)
    {        
        try{   
            if(Auth::user()=='' && Auth::user()->type!='user'){
                \Auth::logout();
                return redirect('login');
            }
            $data['row'] = User::where('id',Auth::user()->id)->first();        
            return view('site.profile.index',$data);    
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified resource in user.
     *
     * @param  \App\Http\Requests\User\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function doUpdateProfile(Request $request)
    {
        $post = $request->all();
            $profileUpdated = User::updateUserProfile($post,$post['id']);
            if($profileUpdated['status']==true){
                return redirect()->back()->with('success', $profileUpdated['message']); 
            }
            else{
                return redirect()->back()->with('error', $profileUpdated['message']);
            } 
        // try{
        //     $post = $request->all();
        //     $profileUpdated = User::updateUserProfile($post,$post['id']);
        //     if($profileUpdated['status']==true){
        //         return redirect()->back()->with('success', $profileUpdated['message']); 
        //     }
        //     else{
        //         return redirect()->back()->with('error', $profileUpdated['message']);
        //     } 
        // }
        // catch(\Exception $ex){
        //     return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        // }
    }

    /**
     * Delete Account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount()
    {
        try{   
            if(Auth::user()=='' && Auth::user()->type!='user'){
                \Auth::logout();
                return redirect('login');
            }
            User::where('id',Auth::user()->id)->delete();   
            \Auth::logout();
            return redirect('login')->with('success',__('lang.message_account_deleted_successfully'));
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }        
    }

    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        \Auth::logout();
        return redirect('login');
    }
}
