<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pairs = [
            // blog_id => category_id
            ['blog_id' => 1, 'category_id' => 1, 'type' => 'category'], // Technology
            ['blog_id' => 2, 'category_id' => 2, 'type' => 'category'], // Health
            ['blog_id' => 3, 'category_id' => 3, 'type' => 'category'], // Business

            // Nouvelles associations
            ['blog_id' => 4, 'category_id' => 4, 'type' => 'category'], // Science
            ['blog_id' => 5, 'category_id' => 5, 'type' => 'category'], // Travel
            ['blog_id' => 6, 'category_id' => 6, 'type' => 'category'], // Food
        ];

        foreach ($pairs as $row) {
            $exists = BlogCategory::where('blog_id', $row['blog_id'])
                ->where('category_id', $row['category_id'])
                ->where('type', $row['type'])
                ->first();
            if (!$exists) {
                BlogCategory::insert([
                    'blog_id' => $row['blog_id'],
                    'category_id' => $row['category_id'],
                    'type' => $row['type'],
                    'created_at' => now()
                ]);
            }
        }
    }
}
