<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Models\Language;
use App\Models\WatermarkSetting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $type
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = null)
    {
        try {
            $data['result'] = Setting::get();
            // echo json_encode($data['result']);exit;
            $data['is_voice_enabled'] = \Helpers::getValueFromKey('is_voice_enabled');
            $data['voice_type'] = \Helpers::getValueFromKey('voice_type');
            $data['languages'] = Language::where('status',1)->get();
            $data['voice_accent'] = config('constant.voice_accent');
            $data['zones'] = timezone_identifiers_list();
            $data['font_family'] = config('constant.font_family');
            $data['current_type'] = $type;
            
            // Ajouter les données de watermark
            $data['watermarkSettings'] = WatermarkSetting::getSettings();
            
            return view('admin/setting.index',$data);
        } 
        catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        try{
            // Si c'est une mise à jour de watermark, utiliser le WatermarkController
            if ($request->input('page_name') === 'watermark-setting') {
                $watermarkController = new \App\Http\Controllers\Admin\WatermarkController();
                return $watermarkController->update($request);
            }
            
            // Si c'est une mise à jour des paramètres de paiement
            if ($request->input('page_name') === 'payment-setting') {
                return $this->updatePaymentSettings($request);
            }
            
            $updated = Setting::updateContent($request->all());
            if($updated['status']){
                return redirect()->back()->with('success', $updated['message']); 
            }
            else{
                return redirect()->back()->with('error', $updated['message']);
            } 
        }
        catch(\Exception $ex){
            return redirect()->back()->with('error', $ex->getMessage() . ' '. $ex->getLine() . ' '. $ex->getFile()); 
        }        
    }

    /**
     * Set language.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setLanguage(Request $request){
        $post = $request->all();
        if (array_key_exists($post['lang'], Config::get('languages'))) {
            if (isset($post['lang'])) {
                App::setLocale($post['lang']);
                Session::put('admin_locale', $post['lang']);
                setcookie('admin_lang_code',$post['lang'],time()+60*60*24*365);
            }
        }
        return redirect()->back();
    }

    // For S3 connection
    public function testS3Connection(Request $request)
    {
        if ($request->hasFile('s3_test_image')) {
            $file = $request->file('s3_test_image');
            $filePath = 'test-images/' . $file->getClientOriginalName();

            try {
                // Attempt to upload the file to S3
                $uploadSuccess = Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
                
                // Verify if the file was successfully uploaded
                if ($uploadSuccess && Storage::disk('s3')->exists($filePath)) {
                    $imagePath = Storage::disk('s3')->url($filePath);

                    // Update the default storage setting
                    Setting::where('key', 'default_storage')->update(['value' => 's3_storage']);
                    Session::put('imagePath', $imagePath);

                    return response()->json(['image_path' => $imagePath]);
                } else {
                    throw new \Exception('Failed to verify S3 connection.');
                }
            } catch (\Exception $e) {
                // Catch and return any errors that occur
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }


    // For local connection
    public function testLocalConnection(Request $request)
    {
        Session::forget('imagePath');
        try {
            Setting::where('key','default_storage')->update(['value' => 'local_storage']);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Test Stripe connection
    public function testStripeConnection(Request $request)
    {
        try {
            $stripeKey = Setting::where('key', 'stripe_secret')->value('value');
            
            if (!$stripeKey) {
                return response()->json(['error' => 'Clé secrète Stripe non configurée'], 400);
            }

            // Vérifier si la classe Stripe existe
            if (!class_exists('\Stripe\Stripe')) {
                return response()->json(['error' => 'SDK Stripe non installé. Exécutez: composer require stripe/stripe-php'], 400);
            }

            \Stripe\Stripe::setApiKey($stripeKey);
            
            // Tester la connexion en récupérant le compte
            $account = \Stripe\Account::retrieve();
            
            return response()->json([
                'success' => true,
                'message' => 'Connexion Stripe réussie',
                'account_id' => $account->id,
                'charges_enabled' => $account->charges_enabled,
                'payouts_enabled' => $account->payouts_enabled
            ]);

        } catch (\Stripe\Exception\AuthenticationException $e) {
            return response()->json(['error' => 'Clé API Stripe invalide'], 400);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return response()->json(['error' => 'Erreur de connexion à Stripe'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }

    // Test PayPal connection
    public function testPayPalConnection(Request $request)
    {
        try {
            $clientId = Setting::where('key', 'paypal_client_id')->value('value');
            $secret = Setting::where('key', 'paypal_secret')->value('value');
            $mode = Setting::where('key', 'paypal_mode')->value('value') ?: 'sandbox';
            
            if (!$clientId || !$secret) {
                return response()->json(['error' => 'Client ID ou Secret PayPal non configuré'], 400);
            }

            // Vérifier si la classe PayPal existe
            if (!class_exists('\PayPalCheckoutSdk\Core\PayPalHttpClient')) {
                return response()->json(['error' => 'SDK PayPal non installé. Exécutez: composer require paypal/rest-api-sdk-php'], 400);
            }

            // Créer l'environnement PayPal
            if ($mode === 'sandbox') {
                $environment = new \PayPalCheckoutSdk\Core\SandboxEnvironment($clientId, $secret);
            } else {
                $environment = new \PayPalCheckoutSdk\Core\ProductionEnvironment($clientId, $secret);
            }

            $client = new \PayPalCheckoutSdk\Core\PayPalHttpClient($environment);
            
            // Tester la connexion en récupérant les informations du compte
            $request = new \PayPalCheckoutSdk\Orders\OrdersGetRequest('test-order-id');
            
            try {
                $response = $client->execute($request);
                return response()->json([
                    'success' => true,
                    'message' => 'Connexion PayPal réussie',
                    'mode' => $mode
                ]);
            } catch (\Exception $e) {
                // Si l'ordre de test n'existe pas, c'est normal, mais la connexion fonctionne
                if (strpos($e->getMessage(), 'RESOURCE_NOT_FOUND') !== false) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Connexion PayPal réussie (ordre de test non trouvé, ce qui est normal)',
                        'mode' => $mode
                    ]);
                }
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur PayPal: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update payment settings
     */
    private function updatePaymentSettings(Request $request)
    {
        try {
            $paymentSettings = [
                'payment_currency' => $request->input('payment_currency', 'USD'),
                'payment_test_mode' => $request->boolean('payment_test_mode') ? '1' : '0',
                
                // Stripe settings
                'stripe_enabled' => $request->boolean('stripe_enabled') ? '1' : '0',
                'stripe_key' => $request->input('stripe_key'),
                'stripe_secret' => $request->input('stripe_secret'),
                'stripe_webhook_secret' => $request->input('stripe_webhook_secret'),
                'stripe_currency' => $request->input('stripe_currency', 'USD'),
                
                // PayPal settings
                'paypal_enabled' => $request->boolean('paypal_enabled') ? '1' : '0',
                'paypal_client_id' => $request->input('paypal_client_id'),
                'paypal_secret' => $request->input('paypal_secret'),
                'paypal_mode' => $request->input('paypal_mode', 'sandbox'),
                'paypal_currency' => $request->input('paypal_currency', 'USD'),
                
                // Redirect URLs
                'payment_success_url' => $request->input('payment_success_url'),
                'payment_cancel_url' => $request->input('payment_cancel_url'),
                
                // Additional settings for better integration
                'payment_webhook_stripe_url' => url('/webhooks/stripe'),
                'payment_webhook_paypal_url' => url('/webhooks/paypal'),
            ];

            // Sauvegarder chaque paramètre sans mass assignment (DB::table)
            foreach ($paymentSettings as $key => $value) {
                if ($value === null) continue;
                $existing = DB::table('settings')->where('key', $key)->first();
                if ($existing) {
                    DB::table('settings')->where('id', $existing->id)->update(['value' => $value]);
                } else {
                    DB::table('settings')->insert(['key' => $key, 'value' => $value, 'created_at' => now(), 'updated_at' => now()]);
                }
            }

            return redirect()->back()->with('success', 'Paramètres de paiement mis à jour avec succès !');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
}
