<?php


namespace App\Services;


use GuzzleHttp\Client;


class ISPservice
{

    public static function isISPinternal($ipAddress)
    {
        // 78.38.248.74
        $actualIpForLookup = ($ipAddress == '127.0.0.1') ? '85.133.175.118' : $ipAddress;
        $isp = self::getISP($actualIpForLookup);

        //PERSOL ISP
        return isset($isp) && (str_contains($isp, '85.133.175.118') || str_contains($isp, '78.38.248.74'));
    }

    public static function getISP($ipAddress)
    {
        try {
            // Make API request to ip-api.com to get IP geolocation data
            $client = new Client();
            $response = $client->get("http://ip-api.com/json/{$ipAddress}", [
                'timeout' => 2,
                'connect_timeout' => 2,
            ]);
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
}
