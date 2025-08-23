<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsContent;
use App\Models\CmsContentTranslation;

class CmsContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cmsArr = array(
            'id'=>1,
            'title' => 'Privacy Policy', 
            'page_title' => \Helpers::createSlug('Privacy Policy','cms',0,false),
            'description'=> 'Privacy Policy',
            'status'=> '1',
        );
        $check = CmsContent::where('title','Privacy Policy')->first();
        if(!$check){
            $id = CmsContent::insertGetID($cmsArr);         
            $cmsContentTransArr = array(
                'cms_id'=>1,
                'language_code'=>'en',
                'title' => 'Privacy Policy', 
                'page_title' => \Helpers::createSlug('Privacy Policy','cms',0,false),
                'description'=> 'Privacy Policy',
                'created_at'=> date('Y-m-d H:i:s')
            );
            CmsContentTranslation::insertGetID($cmsContentTransArr);
        }
    }
}
