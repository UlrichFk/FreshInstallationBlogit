<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WatermarkSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class WatermarkController extends Controller
{
    public function index()
    {
        $watermarkSettings = WatermarkSetting::getSettings();
        return view('admin.setting.watermark_settings', compact('watermarkSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,image',
            'text' => 'required_if:type,text|nullable|string|max:255',
            'watermark_image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'position' => 'required|in:top-left,top-right,bottom-left,bottom-right,center',
            'opacity' => 'required|integer|min:0|max:100',
            'size' => 'required|integer|min:5|max:100',
            'color' => 'required_if:type,text|nullable|string',
            'font_family' => 'required_if:type,text|nullable|string',
            'apply_to_original' => 'boolean',
            'apply_to_768x428' => 'boolean',
            'apply_to_327x250' => 'boolean',
            'apply_to_80x45' => 'boolean',
        ]);

        $watermarkSettings = WatermarkSetting::getSettings();

        $data = [
            'is_enabled' => $request->has('is_enabled'),
            'type' => $request->type,
            'position' => $request->position,
            'opacity' => $request->opacity,
            'size' => $request->size,
            'apply_to_original' => $request->has('apply_to_original'),
            'apply_to_768x428' => $request->has('apply_to_768x428'),
            'apply_to_327x250' => $request->has('apply_to_327x250'),
            'apply_to_80x45' => $request->has('apply_to_80x45'),
        ];

        if ($request->type === 'text') {
            $data['text'] = $request->text;
            $data['color'] = $request->color;
            $data['font_family'] = $request->font_family;
        } else {
            // Handle image upload
            if ($request->hasFile('watermark_image')) {
                // Delete old image if exists
                if ($watermarkSettings->image_path && File::exists(public_path('uploads/watermark/' . $watermarkSettings->image_path))) {
                    File::delete(public_path('uploads/watermark/' . $watermarkSettings->image_path));
                }

                $image = $request->file('watermark_image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/watermark'), $fileName);
                $data['image_path'] = $fileName;
            }
        }

        $watermarkSettings->update($data);

        return redirect()->route('admin.settings.type', ['type' => 'watermark-setting'])->with('success', 'Paramètres de watermark mis à jour avec succès.');
    }

    public function testWatermark(Request $request)
    {
        try {
            $watermarkSettings = WatermarkSetting::getSettings();
            
            if (!$watermarkSettings->is_enabled) {
                return response()->json([
                    'success' => false,
                    'error' => 'Le watermark n\'est pas activé'
                ]);
            }

            // Create a test image
            $testImage = Image::canvas(400, 300, '#f0f0f0');
            
            // Add some text to make it look like a real image
            $testImage->text('Image de test', 200, 150, function($font) {
                $font->size(24);
                $font->color('#333333');
                $font->align('center');
                $font->valign('middle');
            });

            // Apply watermark
            $testImage = \Helpers::applyWatermarkToImage($testImage, 'original');

            // Save test image
            $testFileName = 'test_watermark_' . time() . '.png';
            $testImage->save(public_path('uploads/watermark/' . $testFileName));

            return response()->json([
                'success' => true,
                'test_image_url' => url('uploads/watermark/' . $testFileName)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors du test: ' . $e->getMessage()
            ]);
        }
    }
}