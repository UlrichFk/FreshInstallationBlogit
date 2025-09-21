<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatermarkSetting extends Model
{
    protected $fillable = [
        'is_enabled',
        'type',
        'text',
        'image_path',
        'position',
        'opacity',
        'size',
        'color',
        'font_family',
        'apply_to_original',
        'apply_to_768x428',
        'apply_to_327x250',
        'apply_to_80x45'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'apply_to_original' => 'boolean',
        'apply_to_768x428' => 'boolean',
        'apply_to_327x250' => 'boolean',
        'apply_to_80x45' => 'boolean',
        'opacity' => 'integer',
        'size' => 'integer'
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'is_enabled' => false,
            'type' => 'text',
            'text' => '© ' . date('Y') . ' ' . setting('site_name'),
            'position' => 'bottom-right',
            'opacity' => 50,
            'size' => 20,
            'color' => '#ffffff',
            'font_family' => 'Arial',
            'apply_to_original' => false,
            'apply_to_768x428' => true,
            'apply_to_327x250' => true,
            'apply_to_80x45' => false
        ]);
    }

    public function shouldApplyToSize($size)
    {
        switch ($size) {
            case 'original':
                return $this->apply_to_original;
            case '768x428':
                return $this->apply_to_768x428;
            case '327x250':
                return $this->apply_to_327x250;
            case '80x45':
                return $this->apply_to_80x45;
            default:
                return false;
        }
    }

    public function getImageUrl()
    {
        if ($this->image_path) {
            return url('uploads/watermark/' . $this->image_path);
        }
        return null;
    }
} 