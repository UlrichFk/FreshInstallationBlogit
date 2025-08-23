<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    use HasFactory;


    public function user(){
        return $this->hasOne('App\Models\User',"id","user_id")->select('id','name','photo');
    }

    /**
     * Add or update category
    **/
    public static function addComment($data) {
        try {
            $obj = new self;
            unset($data['_token']);
            unset($data['submit']);
            if(Auth::user()!=''){
                $data['user_id'] = Auth::user()->id;
            }else{
                $data['user_id'] = 1;
            }
            $data['created_at'] = date('Y-m-d H:i:s');
            $category_id = $obj->insertGetId($data);
            return ['status' => true, 'message' => 'Comment added successfully.'];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Add or update record
    **/
    public static function updateComment($data,$id) {
        try {
            $obj = new self;
            unset($data['_token']);            
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->where('id',$id)->update($data);            
            return ['status' => true, 'message' => "Data updated successfully."];  
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Update Columns 
    **/
    public static function updateColumn($id,$name,$value){
        try {
            $obj = new self;
            if($name=='approval_status'){
                $data['approval_status'] = $value;
            }else{
                $data['status'] = $value;
            }    
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->where('id',$id)->update($data);
            return ['status' => true, 'message' => "Data changed successfully."];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Delete particular category
    **/
    public static function deleteCommentRecord($id) {
        try {
            $obj = new self;    
            $obj->where('id',$id)->delete();   
            return ['status' => true, 'message' => "Data deleted successfully."];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
}
