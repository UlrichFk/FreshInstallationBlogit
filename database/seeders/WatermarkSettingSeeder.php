<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WatermarkSetting;

class WatermarkSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WatermarkSetting::create([
            'is_enabled' => false,
            'type' => 'text',
            'text' => '© ' . date('Y') . ' ' . config('app.name'),
            'position' => 'bottom-right',
            'opacity' => 50,
            'size' => 20,
            'color' => '#ffffff',
            'font_family' => 'Arial',
            'apply_to_original' => false,
            'apply_to_768x428' => true,
            'apply_to_327x250' => true,
            'apply_to_80x45' => false,
        ]);
    }
} 