<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    /**
     * Fetch list of categories from here
    **/
    public static function getLists($search){
        try {
            $obj = new self;
            $categoryArr = array();
            $pagination = (isset($search['perpage']))?$search['perpage']:config('constant.pagination');
            if(isset($search['name']) && !empty($search['name'])){
                $obj = $obj->where(function($q) use ($keyword){
                    $q->where(DB::raw('LOWER(name)'), 'like', '%'.strtolower($keyword). '%')
                    ->orWhere(DB::raw('LOWER(email)'),'like','%'.strtolower($keyword). '%')
                    ->orWhere(DB::raw('LOWER(message)'),'like','%'.strtolower($keyword). '%');
                });                
            }  
            $data = $obj->latest('created_at')->paginate($pagination)->appends('perpage', $pagination);
            if(count($data)){
                foreach($data as $row){
                    $row->blog_count = BlogCategory::where('category_id',$row->id)->count();
                }
            }
            return $data;
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
    /**
     * Add or update category
    **/
    public static function replyQuery($data,$id) {
        try {
            $obj = new self;
            unset($data['_token']);
            $contact = ContactUs::where('id',$id)->first();
            if(isset($data['reply']) && $data['reply']!=''){
                if($contact){
                    $dataArr = array(
                        'name'=>$contact->name,
                        'text'=>$data['reply']
                    );
                    $c = \Helpers::sendEmail('emails.reply',$dataArr,$contact->email,$contact->name, setting('site_name'). ' reply for your query.', setting('site_name'). ' App',setting('from_email'),'');
                    return ['status' => true, 'message' => "Data updated successfully."];  
                }
            }            
            
        }
        catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage() . ' '. $e->getLine() . ' '. $e->getFile()];
        }
    }
}
