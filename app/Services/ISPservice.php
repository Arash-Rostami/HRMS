<?php


namespace App\Services;


use GuzzleHttp\Client;


class ISPservice
{

    public static function getISP($ipAddress)
    {
        try {
            // Make API request to ip-api.com to get IP geolocation data
            $client = new Client();
            $response = $client->get("http://ip-api.com/json/{$ipAddress}");

            // Parse the JSON response
            $data = json_decode($response->getBody(), true);

            // Get the ISP information from the response
            $isp = $data['query'] ?? null;
        } catch (\Exception $e) {
            // Set ISP to null if the API request fails or throws an exception
            $isp = null;
        }

        // Return the ISP information
        return $isp;
    }


    public static function isISPinternal($ipAddress)
    {
        // 78.38.248.74
        $isp = ($ipAddress == '127.0.0.1') ? self::getISP('85.133.175.118') : self::getISP($ipAddress);

        //PERSOL ISP
        return isset($isp) && $isp == '85.133.175.118' or $isp == '78.38.248.74';
    }
}
