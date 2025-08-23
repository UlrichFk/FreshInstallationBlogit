<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use anlutro\LaravelSettings\Facade as ContentSetting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tempArr = array(
            'homepage_theme' => 'home_2',
            'layout' => 'index_1',
            'site_name' => 'Blogit Flutter App with Admin Panel',
            'site_admin_name'=>'Admin Blogit',
            'site_phone' => '+91-7987162771',
            'from_email' => 'info@blogit.com',
            'footer_about' => 'The tag defines a footer for a document or section. A element typically contains: authorship information. copyright information. contact information',
            'powered_by' => 'All Rights Reserved Powered by Blogit.',
            'site_seo_title' => 'Blogit Flutter App with Admin Panel',
            'site_seo_description' => 'Blogit Flutter App with Admin Panel',
            'site_seo_keyword' => 'Blogit Flutter App with Admin Panel',
            'site_seo_tag' => 'Blogit Flutter App with Admin Panel',
            'preferred_site_language' => 'en',
            'news_api_key' => '',
            'chat_gpt_api_key'=>'',
            'google_translation_api_key'=>'',
            'google_analytics_code' => '',
            'site_logo' => '',
            'website_admin_logo' => '',
            'site_favicon'=>'',
            'app_name' => 'Blogit',
            'support_email' => 'support@gmail.com',
            'bundle_id_android'=>'',
            'bundle_id_ios'=>'',
            'signing_key_android' => '',
            'key_property_android'=>'',            
            'is_app_force_update'=>'',   
            'light_mode_primary_color'=>'#000000',
            'dark_mode_primary_color'=>'#000000',   
            'android_rate_us'=>'',      
            'ios_rate_us'=>'',
            'is_autoapprove_enable'=> 1,      
            'app_logo' => '',
            'rectangualr_app_logo'=>'',
            'app_splash_screen' => '',
            'site_title' => 'Blogit',    
            'enable_notifications' => 1,
            'firebase_msg_key' => '',
            'firebase_api_key' => '',  
            'one_signal_key'=>'',
            'one_signal_app_id'=>'',
            'mailer' => '',
            'host' => '',
            'port' => '',
            'username'=>'',
            'password' => '',
            'encryption'=>'',
            'from_name'=>'',
            'bundle_id_ios'=>'',       
            'enable_maintainance_mode'=>0,
            'maintainance_title'=>'Comming Soon!',
            'maintainance_short_text'=>'We are preparing something better & amazing for you.' ,             
            'push_notification_enabled' => 1,
            'date_format' => 'd-m-Y h:i A',
            'timezone' => 'Asia/Kolkata',
            'blog_language'=>'',
            'blog_accent'=>'',
            'blog_voice'=>'',
            'blog_accent_code' => 'uk-UA',
            'google_api_key'=>'',
            'voice_type'=>'',
            'is_voice_enabled'=>0,
            'live_news_logo' => '',
            'live_news_status' => 0,
            'e_paper_logo' => '',
            'e_paper_status' => 0,            
            'enable_ads' => 0,
            'admob_banner_id_android' => '',
            'admob_interstitial_id_android' => '',
            'admob_banner_id_ios' => '',
            'admob_interstitial_id_ios' => '',
            'admob_frequency' => 0,
            'enable_fb_ads' => 1,
            'fb_ads_placement_id_android' => '',
            'fb_ads_placement_id_ios' => '',
            'fb_ads_app_token' => '',
            'fb_ads_frequency' => 0,
            'fb_ads_interstitial_id_android' => '',
            'fb_ads_interstitial_id_ios' => '',
            'blog_type_section_1'=>'by_all_blogs',
            'blog_type_section_2'=>'by_all_blogs',
            'blog_type_section_3'=>'by_all_blogs',
            'blog_type_section_4'=>'by_all_blogs',
            'blog_type_section_5'=>'',
            'visibility_section_1'=>'',
            'visibility_section_2'=>'',
            'visibility_section_3'=>'',
            'visibility_section_4'=>'',
            'visibility_section_5'=>'',
            'category_section_1'=>'',
            'category_section_2'=>'',
            'category_section_3'=>'',
            'category_section_4'=>'',
            'category_section_5'=>'',
            'sub_category_section_1'=>'',
            'sub_category_section_2'=>'',
            'sub_category_section_3'=>'',
            'sub_category_section_4'=>'',
            'sub_category_section_5'=>'',
            'section'=>'section_1,section_2,section_3,section_4',
            'enable_share_setting' => '0',
            'android_schema'=>'',
            'playstore_url'=>'',
            'ios_schema'=>'',
            'appstore_url'=>'',
            'default_storage' => 'local_storage',
            'enable_storage_setting' => 0,
            'aws_access_key_id' => '',
            'aws_secret_access_key' => '',
            'aws_default_region' => '',
            'aws_bucket' => '',
            'aws_url' => '',
            'is_android_app_force_update' => 0,
            'is_ios_app_force_update' => 0,
            'enable_stories' => 0,
            'enable_select_language_appear' => 0,
            'enable_skip' => 0,
         );
         
         foreach ($tempArr as $key => $value) {
            $check = Setting::where('key',$key)->first();
            if(!$check){
                Setting::insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }
        }
        $settingsc = Setting::all();
        foreach ($settingsc as $row) {
            ContentSetting::set($row->key, $row->value);
        }
        ContentSetting::save();
    }
}
