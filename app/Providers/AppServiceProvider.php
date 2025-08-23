<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Attempt to retrieve the timezone from the settings table
            $timezoneSetting = Setting::where('key', 'timezone')->first();
            
            if ($timezoneSetting && $timezoneSetting->value) {
                // If the timezone setting exists, set the timezone dynamically
                config(['app.timezone' => $timezoneSetting->value]);
                date_default_timezone_set($timezoneSetting->value);
            } else {
                // If the timezone setting doesn't exist or is empty, fallback to a default timezone
                config(['app.timezone' => 'Asia/Kolkata']);
                date_default_timezone_set('Asia/Kolkata');
            }

            // AWS Configuration
            $awsAccessKeySetting = Setting::where('key', 'aws_access_key_id')->first();
            $awsSecretKeySetting = Setting::where('key', 'aws_secret_access_key')->first();
            $awsRegionSetting = Setting::where('key', 'aws_default_region')->first();
            $awsBucketSetting = Setting::where('key', 'aws_bucket')->first();
            $awsUrlSetting = Setting::where('key', 'aws_url')->first();

            if ($awsAccessKeySetting && $awsAccessKeySetting->value) {
                config(['filesystems.disks.s3.key' => $awsAccessKeySetting->value]);
            }

            if ($awsSecretKeySetting && $awsSecretKeySetting->value) {
                config(['filesystems.disks.s3.secret' => $awsSecretKeySetting->value]);
            }

            if ($awsRegionSetting && $awsRegionSetting->value) {
                config(['filesystems.disks.s3.region' => $awsRegionSetting->value]);
            }

            if ($awsBucketSetting && $awsBucketSetting->value) {
                config(['filesystems.disks.s3.bucket' => $awsBucketSetting->value]);
            }

            if ($awsUrlSetting && $awsUrlSetting->value) {
                config(['filesystems.disks.s3.url' => $awsUrlSetting->value]);
            }

        } catch (Exception $e) {
            // If there is an exception (e.g., database connection fails), log the error
            Log::error('Database connection failed: ' . $e->getMessage());
        }
    }
}
