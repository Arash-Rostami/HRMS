<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherAPI
{
    private static $apiKeys = [
        '67e453109f1d2b7cf37fbb8cdf422022',
        '08c823b4f169b6dc0a70124e9f2e9318',
        '24f2a5a57d35c4cddd68327d4da3b637'
    ];

    public static function getWeather()
    {
        $apiKey = self::$apiKeys[array_rand(self::$apiKeys)];
        $url = "http://api.openweathermap.org/data/2.5/weather?q=Tehran&appid=$apiKey&units=metric";
        $defaultWeather = ['weather' => '', 'temperature' => 'Weather Off'];

        try {
            $client = new Client([
                'timeout'         => 5, // Response timeout
                'connect_timeout' => 3,  // Connection timeout
            ]);

            $response = $client->get($url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $data = json_decode($response->getBody(), true);

                if (isset($data['weather'][0]['main']) && isset($data['main']['temp'])) {
                    return [
                        'weather' => $data['weather'][0]['main'],
                        'temperature' => round($data['main']['temp'])
                    ];
                }
            }
        } catch (\Exception $e) {
            return $defaultWeather;
        }

        return $defaultWeather;
    }
}
