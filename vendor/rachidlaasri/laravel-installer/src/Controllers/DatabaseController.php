<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use RachidLaasri\LaravelInstaller\Helpers\DatabaseManager;
use Illuminate\Support\Facades\File;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        
        
        // putenv('APP_INSTALLED=true');

        // Update the .env file with the new value
        File::put(base_path('.env'), str_replace(
            'APP_INSTALLED=false',
            'APP_INSTALLED=true',
            file_get_contents(base_path('.env'))
        ));
        $response = $this->databaseManager->migrateAndSeed();
      

        return redirect()->route('LaravelInstaller::final')
                         ->with(['message' => $response]);
    }
}
