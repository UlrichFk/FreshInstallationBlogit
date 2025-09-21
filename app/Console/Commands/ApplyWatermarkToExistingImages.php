<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogImage;
use App\Models\WatermarkSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ApplyWatermarkToExistingImages extends Command
{
    protected $signature = 'watermark:apply-to-existing {--dry-run : Show what would be processed without making changes}';
    protected $description = 'Apply watermark to existing blog images';

    public function handle()
    {
        $watermarkSettings = WatermarkSetting::getSettings();
        
        if (!$watermarkSettings->is_enabled) {
            $this->error('Watermark is not enabled. Please enable it first in the admin panel.');
            return Command::FAILURE;
        }

        $this->info('Starting watermark application to existing images...');
        
        $blogImages = BlogImage::all();
        $totalImages = $blogImages->count();
        $processedImages = 0;
        $errors = [];

        $this->info("Found {$totalImages} images to process.");

        if ($this->option('dry-run')) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        $progressBar = $this->output->createProgressBar($totalImages);
        $progressBar->start();

        foreach ($blogImages as $blogImage) {
            try {
                $this->processImage($blogImage, $watermarkSettings);
                $processedImages++;
            } catch (\Exception $e) {
                $errors[] = "Error processing image {$blogImage->image}: " . $e->getMessage();
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("Processed {$processedImages} images successfully.");

        if (!empty($errors)) {
            $this->error('Errors encountered:');
            foreach ($errors as $error) {
                $this->error("- {$error}");
            }
        }

        if ($this->option('dry-run')) {
            $this->warn('This was a dry run. Run without --dry-run to apply changes.');
        } else {
            $this->info('Watermark application completed!');
        }

        return Command::SUCCESS;
    }

    private function processImage($blogImage, $watermarkSettings)
    {
        $imageName = $blogImage->image;
        $basePath = public_path('uploads/blog/');
        
        $sizes = [
            'original' => 'original',
            '768x428' => '768x428',
            '327x250' => '327x250',
            '80x45' => '80x45'
        ];

        foreach ($sizes as $size => $folder) {
            $imagePath = $basePath . $folder . '/' . $imageName;
            
            if (!File::exists($imagePath)) {
                continue;
            }

            if (!$watermarkSettings->shouldApplyToSize($size)) {
                continue;
            }

            if ($this->option('dry-run')) {
                $this->line("Would process: {$imagePath}");
                continue;
            }

            $image = Image::make($imagePath);
            $image = \Helpers::applyWatermarkToImage($image, $size);
            $image->save($imagePath);
        }
    }
} 