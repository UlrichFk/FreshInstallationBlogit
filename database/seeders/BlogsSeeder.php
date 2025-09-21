<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogTranslation;
use App\Models\BlogVisibility;

class BlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Plans d'abonnement disponibles (assumés créés par MembershipPlanSeeder)
        $basicPlanId = 1; // Adapter si besoin
        $premiumPlanId = 2; // Adapter si besoin

        $blogArr = [
            [
                'id' =>  1,
                'type' => 'post',
                'title' => 'Demo Blog 1', 
                'description' => 'Demo Blog 1', 
                'seo_title' => 'Demo Blog 1', 
                'seo_description' => 'Demo Blog 1',
                'slug' => \Helpers::createSlug('Demo Blog 1', 'blog', 0, false),
                'status' => 1,
                'order' => 1,
                'created_by' => 1,
                'schedule_date' => now(),
                // Restriction: gratuit (non premium)
                'is_premium' => false,
                'required_plan_id' => null,
                'created_at' => now()
            ],
            [
                'id' =>  2,
                'type' => 'post',
                'title' => 'Demo Blog 2', 
                'description' => 'Demo Blog 2', 
                'seo_title' => 'Demo Blog 2', 
                'seo_description' => 'Demo Blog 2',
                'slug' => \Helpers::createSlug('Demo Blog 2', 'blog', 0, false),
                'status' => 1,
                'order' => 1,
                'created_by' => 1,
                'schedule_date' => now(),
                // Restriction: premium (plan de base)
                'is_premium' => true,
                'required_plan_id' => $basicPlanId,
                'created_at' => now()
            ],
            [
                'id' =>  3,
                'type' => 'post',
                'title' => 'Demo Blog 3', 
                'description' => 'Demo Blog 3', 
                'seo_title' => 'Demo Blog 3', 
                'seo_description' => 'Demo Blog 3',
                'slug' => \Helpers::createSlug('Demo Blog 3', 'blog', 0, false),
                'status' => 1,
                'order' => 1,
                'created_by' => 1,
                'schedule_date' => now(),
                // Restriction: premium (plan premium)
                'is_premium' => true,
                'required_plan_id' => $premiumPlanId,
                'created_at' => now()
            ],
            // Nouveaux articles
            [
                'id' =>  4,
                'type' => 'post',
                'title' => 'Exploring Quantum Computing', 
                'description' => 'An introduction to the fundamentals and potential of quantum computing.', 
                'seo_title' => 'Quantum Computing Basics', 
                'seo_description' => 'Learn the basics of quantum computing and its potential applications.',
                'slug' => \Helpers::createSlug('Exploring Quantum Computing', 'blog', 0, false),
                'status' => 1,
                'order' => 4,
                'created_by' => 1,
                'schedule_date' => now(),
                'is_premium' => true,
                'required_plan_id' => $premiumPlanId,
                'created_at' => now()
            ],
            [
                'id' =>  5,
                'type' => 'post',
                'title' => 'Top 10 Travel Destinations for 2025', 
                'description' => 'Discover the most breathtaking destinations to visit this year.', 
                'seo_title' => 'Best Travel Destinations 2025', 
                'seo_description' => 'Explore the top travel spots for 2025 across the globe.',
                'slug' => \Helpers::createSlug('Top 10 Travel Destinations for 2025', 'blog', 0, false),
                'status' => 1,
                'order' => 5,
                'created_by' => 1,
                'schedule_date' => now(),
                'is_premium' => false,
                'required_plan_id' => null,
                'created_at' => now()
            ],
            [
                'id' =>  6,
                'type' => 'post',
                'title' => 'Healthy and Delicious Vegan Recipes', 
                'description' => 'A collection of easy and nutritious vegan recipes for daily cooking.', 
                'seo_title' => 'Vegan Recipes Collection', 
                'seo_description' => 'Cook healthy and delicious vegan dishes with these simple recipes.',
                'slug' => \Helpers::createSlug('Healthy and Delicious Vegan Recipes', 'blog', 0, false),
                'status' => 1,
                'order' => 6,
                'created_by' => 1,
                'schedule_date' => now(),
                'is_premium' => false,
                'required_plan_id' => null,
                'created_at' => now()
            ],
        ];

        foreach ($blogArr as $row) {
            $check = Blog::find($row['id']);
            if (!$check) {
                $id = Blog::insertGetId($row); 
                $blogTransArr = [
                    'blog_id' => $id,
                    'language_code' => 'en',
                    'title' => $row['title'], 
                    'description' => $row['description'], 
                    'seo_title' => $row['seo_title'], 
                    'seo_description' => $row['seo_description'],
                    'created_at' => now()
                ];
                BlogTranslation::insert($blogTransArr);

                // Associer au moins une visibilité existante (1 par défaut)
                $blogVisArr = [
                    'blog_id' => $id,
                    'visibility_id' => 1,
                    'created_at' => now()
                ];
                BlogVisibility::insert($blogVisArr);
            }            
        }
    }
}
