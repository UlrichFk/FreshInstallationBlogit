<?php

namespace BeycanPress;

use GuzzleHttp\Client;

/**
 * @link https://github.com/BeycanPress/envato-license-checker
 * @author BeycanPress
 * @version 0.1.0
 */
class EnvatoLicenseChecker
{
    private static $bearer;

    private static $verifyURL = 'https://api.envato.com/v3/market/author/sale/';

    /**
     * To add the token you created through Envato.
     * 
     * @param string $token
     * @return void
     */
    public static function setBearerToken(string $token)
    {
        self::$bearer = $token;
    }

    /**
     * Prepare request header and baerer token
     * 
     * @return string
     */
    public static function prepareHeader()
    {
        $header   = [
            'Content-type: application/json; charset=utf-8',
            'Authorization: Bearer ' . self::$bearer,
        ];

        return $header;
    }
    
    /**
     * The method where you can fetch the purchase data of the purchase code you entered
     * 
     * @param string $code
     * @return object
     */
    public static function getPurchaseData(string $code)
    {
        $curlURL = curl_init(self::$verifyURL . '?code=' . $code);
        
        curl_setopt($curlURL, CURLOPT_HTTPHEADER, self::prepareHeader());
        curl_setopt($curlURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlURL, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curlURL, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        
        $result = curl_exec($curlURL);
        curl_close($curlURL);
        
        if ($result != "") {    
            return json_decode($result);  
        } else {
            return false;
        }
        
    }
    
    /**
     * It checks the validity of the purchase code you entered and returns true false.
     * 
     * @param string $code
     * @return bool
     */
    // static function check(string $code)
    // {
    //     $purchaseData = self::getPurchaseData($code); 

    //     if ( 
    //         (false === $purchaseData) || 
    //         !is_object($purchaseData) ||
    //         isset($purchaseData->error) ||
    //         !isset($purchaseData->sold_at)
    //     ) {
    //         return false;
    //     }
        
    //     if (
    //         $purchaseData->supported_until == "" ||
    //         $purchaseData->supported_until != null
    //     ) {
    //         return $purchaseData;  
    //     }
        
    //     return false;
    // }

    public function check($purchaseCode)
    {
        $client = new Client();
        $response = $client->get('https://api.envato.com/v3/market/author/sale', [
            'headers' => [
                'Authorization' => 'Bearer 3hd7zh4BFiXg22PC4GkRh1PnPiqI38Pt',
                'User-Agent' => 'LicenseChecker/1.0'
            ],
            'query' => [
                'code' => $purchaseCode
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        if (isset($data['error'])) {
            // An error occurred
            return false;
        } else {
            // Valid purchase code
            $license = new License();
            $license->setLicenseKey($purchaseCode);
            $license->setActivated($data['license']['activated']);
            $license->setExpires($data['license']['expires']);
            return $license;
        }
    }
}