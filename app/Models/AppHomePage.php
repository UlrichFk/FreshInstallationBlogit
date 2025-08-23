<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AppHomePage extends Model
{
    use HasFactory;
    protected $table = "app_home_pages";

    /**
     * Fetch list of categories from here
    **/
    public static function getLists($search){
        try {
            $obj = new self;
            $blogIdArr = array();
            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');
            if(isset($search['title']) && !empty($search['title']))
            {
                $obj = $obj->where('title', 'like', '%'.trim($search['title']).'%');
            }   
            if(isset($search['status']) && $search['status']!='')
            {
                $obj = $obj->where('status',$search['status']);
            }
            $data = $obj->orderBy('order','ASC')->paginate($pagination)->appends('perpage', $pagination);
            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
    /**
     * Add or update data
    **/
    public static function addUpdate($data, $id=0)
    {
        try {
            $obj = new self;
            unset($data['_token']);
            unset($data['button_name']);

            if ($id == 0) {
                // Handle `category_id`
                if (isset($data['category_id']) && $data['category_id'] != '') {
                    $category_id = $data['category_id'];
                    $data['category_id'] = implode(',', $category_id);
                } else {
                    unset($data['category_id']);
                }
                
                // Handle `sub_category_id`
                if (isset($data['sub_category_id']) && $data['sub_category_id'] != '') {
                    $sub_category_id = $data['sub_category_id'];
                    $data['sub_category_id'] = implode(',', $sub_category_id);
                } else {
                    unset($data['sub_category_id']);
                }
                
                // Handle `visibility_id`
                if (isset($data['visibility_id']) && $data['visibility_id'] != '') {
                    $data['visibility_id'] = $data['visibility_id'];
                } else {
                    unset($data['visibility_id']);
                }
                
                // Set default values
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                
                // Get the next `order` value
                $highestOrder = DB::table('app_home_pages')->max('order');
                $data['order'] = $highestOrder ? $highestOrder + 1 : 1; // If no records exist, start at 1
                
                // Insert the data
                $entry_id = $obj->insertGetId($data);
                
                return ['status' => true, 'message' => "Data added successfully."];
            }
            else
            {
                if($data['type'] =='by_category'){
                    $data['visibility_id'] = '';
                   
                    if(isset($data['category_id']) && $data['category_id']!=''){
                        $category_id = $data['category_id'];
                        $data['category_id'] = implode(',', $category_id);
                    }
                    
                    if(isset($data['sub_category_id']) && $data['sub_category_id']!=''){
                        $sub_category_id = $data['sub_category_id'];
                        $data['sub_category_id'] = implode(',', $sub_category_id);
                    }
                    
                }else if($data['type'] =='by_visibility'){
                    $data['sub_category_id'] = '';
                    $data['category_id'] = '';
                    
                    if(isset($data['visibility_id']) && $data['visibility_id']!=''){
                        $data['visibility_id'] = $data['visibility_id'];
                    }
                    
                }else{
                    $data['sub_category_id'] = '';
                    $data['category_id'] = '';
                    $data['visibility_id'] = '';
                }
                
                $obj->where('id',$id)->update($data);
                return ['status' => true, 'message' => "Data updated successfully."];
            }
            
        } catch (\Exception $e) 
        {
    		return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
    	}
    	
    }

    /**
     * Fetch particular detail
    **/
    public static function getDetail($id)
    {
        try 
        {
            $obj = new self;
            $data = $obj->where('id',$id)->firstOrFail();
            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }

    /**
     * Delete particular epaper
    **/
    public static function deleteRecord($id) 
    {
        try 
        {
            $obj = new self;    
            $obj->where('id',$id)->delete();   
            BlogTranslation::where('blog_id',$id)->delete();
            return ['status' => true, 'message' => config('constant.common.messages.success_delete')];
        }
        catch (\Exception $e) 
        {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
    
    /**
     * Update Columns 
    **/
    public static function changeStatus($value, $id)
    {
        try {
            $obj = new self;
            $data['status'] = $value;
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->where('id',$id)->update($data);
            return ['status' => true, 'message' => "Data changed successfully."];
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
}
