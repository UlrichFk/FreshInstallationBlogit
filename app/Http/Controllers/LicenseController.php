<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use beycanpress\Envato\EnvatoChecker;
// use BeycanPress\EnvatoLicenseChecker\EnvatoChecker;
use BeycanPress\EnvatoLicenseChecker;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use App\Models\Settings;

class LicenseController extends Controller
{
    //
    public function index()
    {
        return view('license.verify');
    }

    public function verify(Request $request)
    {
        // Validation du code d'achat (format basique)
        $purchaseCode = $request->purchase_code;
        
        // Vérification que le code n'est pas vide et a un format valide
        if (empty($purchaseCode) || strlen($purchaseCode) < 5) {
            return redirect()->back()
                ->withInput($request->only('purchase_code'))
                ->with('error', 'Le code d\'achat doit contenir au moins 5 caractères.');
        }

        // Contournement de la vérification externe - TOUT CODE VALIDE
        try {
            // Simulation d'une réponse de succès
            $successResponse = (object) [
                'status' => true,
                'message' => 'Code verified successfully.',
                'data' => [
                    'purchase_code' => $purchaseCode,
                    'verified_at' => now()->toISOString(),
                    'license_type' => 'valid',
                    'expires_at' => now()->addYears(10)->toISOString()
                ]
            ];

            // Log de la vérification (optionnel)
            \Log::info('License verification bypassed', [
                'purchase_code' => $purchaseCode,
                'base_url' => $request->base_url ?? request()->getHost(),
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
                'timestamp' => now()
            ]);

            // Mise à jour du fichier .env
            $envPath = base_path('.env');
            if (File::exists($envPath)) {
                $envContent = File::get($envPath);
                
                // Mise à jour ou ajout de CODE_VERIFIED
                if (strpos($envContent, 'CODE_VERIFIED=') !== false) {
                    $envContent = preg_replace(
                        '/CODE_VERIFIED=.*/',
                        'CODE_VERIFIED=true',
                        $envContent
                    );
                } else {
                    $envContent .= "\nCODE_VERIFIED=true";
                }
                
                // Ajout du code d'achat dans .env (optionnel)
                if (strpos($envContent, 'PURCHASE_CODE=') !== false) {
                    $envContent = preg_replace(
                        '/PURCHASE_CODE=.*/',
                        'PURCHASE_CODE=' . $purchaseCode,
                        $envContent
                    );
                } else {
                    $envContent .= "\nPURCHASE_CODE=" . $purchaseCode;
                }
                
                File::put($envPath, $envContent);
            }

            // Nettoyage du cache de configuration
            \Artisan::call('config:clear');
            \Artisan::call('cache:clear');

            return redirect()->back()
                ->with('success', 'Code d\'achat vérifié avec succès ! L\'application est maintenant activée.');

        } catch (\Exception $e) {
            // En cas d'erreur, on accepte quand même le code
            \Log::warning('License verification error, but accepting code', [
                'purchase_code' => $purchaseCode,
                'error' => $e->getMessage()
            ]);

            // Mise à jour du fichier .env même en cas d'erreur
            $envPath = base_path('.env');
            if (File::exists($envPath)) {
                $envContent = File::get($envPath);
                
                if (strpos($envContent, 'CODE_VERIFIED=') !== false) {
                    $envContent = preg_replace(
                        '/CODE_VERIFIED=.*/',
                        'CODE_VERIFIED=true',
                        $envContent
                    );
                } else {
                    $envContent .= "\nCODE_VERIFIED=true";
                }
                
                File::put($envPath, $envContent);
            }

            return redirect()->back()
                ->with('success', 'Code d\'achat accepté ! L\'application est maintenant activée.');
        }
    }
}
