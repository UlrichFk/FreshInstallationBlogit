<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run()
    {
    $categoryArr = [
        array(
            'id' => '1',
            'parent_id'=>'0',
            'name' => 'Technology', 
            'slug' => \Helpers::createSlug('Technology','category',0,false),
            'color'=> '#2563eb',
            'order'=> '1',
            'status'=> '1',
            'is_featured'=> '1'
        ),
        array(
            'id' => '2',
            'parent_id'=>'0',
            'name' => 'Health', 
            'slug' => \Helpers::createSlug('Health','category',0,false),
            'color'=> '#16a34a',
            'order'=> '2',
            'status'=> '1',
            'is_featured'=> '1'
        ),
        array(
            'id' => '3',
            'parent_id'=>'0',
            'name' => 'Business', 
            'slug' => \Helpers::createSlug('Business','category',0,false),
            'color'=> '#f59e0b',
            'order'=> '3',
            'status'=> '1',
            'is_featured'=> '1'
        ),
        // Nouvelles catégories
        array(
            'id' => '4',
            'parent_id'=>'0',
            'name' => 'Science', 
            'slug' => \Helpers::createSlug('Science','category',0,false),
            'color'=> '#7c3aed',
            'order'=> '4',
            'status'=> '1',
            'is_featured'=> '1'
        ),
        array(
            'id' => '5',
            'parent_id'=>'0',
            'name' => 'Travel', 
            'slug' => \Helpers::createSlug('Travel','category',0,false),
            'color'=> '#0ea5e9',
            'order'=> '5',
            'status'=> '1',
            'is_featured'=> '1'
        ),
        array(
            'id' => '6',
            'parent_id'=>'0',
            'name' => 'Food', 
            'slug' => \Helpers::createSlug('Food','category',0,false),
            'color'=> '#ef4444',
            'order'=> '6',
            'status'=> '1',
            'is_featured'=> '1'
        ),
    ];
    
    foreach ($categoryArr as $row) {
        $check = Category::find($row['id']);
        if (!$check) {
            $id = Category::insertGetId($row);   
            $blogTransArr = array(
                'category_id'=> $id,
                'language_code'=>'en',
                'name' => $row['name'], 
                'created_at'=> now()
            );
            CategoryTranslation::insertGetId($blogTransArr);
        }
    }
    }

}
