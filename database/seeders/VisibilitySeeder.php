<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visibility;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
    $VisArr = [
        array(
            'id' => '1',
            'display_name' => 'Demo Visibility 1', 
            'is_app'=> '1',
            'status'=> '1',
        ),
        array(
            'id' => '2',
            'display_name' => 'Demo Visibility 2', 
            'is_app'=> '1',
            'status'=> '1',
        ),
        array(
            'id' => '3',
            'display_name' => 'Demo Visibility 3', 
            'is_app'=> '1',
            'status'=> '1',
        )
    ];

    $i = 0;
    foreach ($VisArr as $row) {
        $check = Visibility::find($row['id']);
        if (!$check) {
            $id = Visibility::insertGetId($row);   
            $i++;
        }
    }
    }

}
