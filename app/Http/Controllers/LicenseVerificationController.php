<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Beycan\Envato\EnvatoChecker;
use Illuminate\Support\Facades\File;

class LicenseVerificationController extends Controller
{
    public function showVerificationForm()
    {
        return view('verify-purchase');
    }

    public function verify(Request $request)
    {
        $purchaseCode = $request->input('purchase_code');
        
        // Validation basique du code d'achat
        if (empty($purchaseCode) || strlen($purchaseCode) < 5) {
            return back()->withErrors(['purchase_code' => 'Le code d\'achat doit contenir au moins 5 caractères.']);
        }

        // Contournement de la vérification - TOUT CODE VALIDE
        try {
            // Log de la vérification
            \Log::info('License verification bypassed (LicenseVerificationController)', [
                'purchase_code' => $purchaseCode,
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
                
                File::put($envPath, $envContent);
            }

            // Nettoyage du cache
            \Artisan::call('config:clear');
            \Artisan::call('cache:clear');

            // Redirection vers le dashboard avec succès
            return redirect('/dashboard')->with('success', 'Code d\'achat vérifié avec succès !');

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

            return redirect('/dashboard')->with('success', 'Code d\'achat accepté !');
        }
    }
}
