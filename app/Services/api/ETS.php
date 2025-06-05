<?php

namespace App\Services\api;

use App\Events\UpdateLastSeen;
use App\Events\userLoggedInETS;
use App\Events\UserLoggedOut;
use GuzzleHttp\Client;
use Morilog\Jalali\Jalalian;
use GuzzleHttp\Psr7\Uri;


abstract class ETS
{
    public string $ip;
    public Client $client;
    public string $currentDate;
    public array $attendanceData;

    public function __construct()
    {
        //        78.38.248.74:8085 -- server config
        //        192.168.10.4:8085 -- local config
        $this->ip = new Uri(config('services.my_service.api_url'));
        $this->client = new Client();
        $this->currentDate = Jalalian::now()->format('Y/m/d');
        $this->attendanceData = [];
    }

    public function extractBody(\Psr\Http\Message\ResponseInterface $response): null|false|\SimpleXMLElement
    {
        $xml = simplexml_load_string($response->getBody()->getContents());
        $soapNamespace = $xml->getNamespaces(true)['soap'];
        return $xml->children($soapNamespace)->Body;
    }

    public function changePresence(string $employeeCode): array
    {
        $entryTime = $this->attendanceData[$employeeCode]['entryTime'];
        $exitTime = $this->attendanceData[$employeeCode]['exitTime'];


        if (!is_null($entryTime) && is_null($exitTime)) {
            $this->attendanceData[$employeeCode]['presence'] = 'onsite';
        } elseif (!is_null($entryTime) && !is_null($exitTime)) {
            $this->attendanceData[$employeeCode]['presence'] = 'on-leave';
        } else {
            $this->attendanceData[$employeeCode]['presence'] = 'off-site';
        }
        return $this->attendanceData;
    }

    public function logUserOut(mixed $profile): void
    {
        // Dispatch the event to update the last seen time
//        event(new UpdateLastSeen($profile->user));
        // Dispatch the event to update presence status to on-leave
//        event(new UserLoggedOut($profile->user));
    }


    public function logUserIn(mixed $profile)
    {
        if ($profile->user == null) {
            return response()->json([
                'message' => 'No user associated with this profile.',
            ], 404); // You can change the status code to a suitable one (e.g., 404 Not Found)
        }

        // Dispatch the event to update the last seen time
        event(new UpdateLastSeen($profile->user));
        // Dispatch the event to update presence status to onsite
        event(new UserLoggedInETS($profile->user));
    }


    abstract public function prepareSoapRequest(): string;

    abstract public function sendSoapRequest(string $soapRequest): \Psr\Http\Message\ResponseInterface;

    abstract public function receiveSoapResponse(\Psr\Http\Message\ResponseInterface $response): null|false|\SimpleXMLElement;

    abstract public function processSoapResponse(\SimpleXMLElement|bool|null $recordsResult): array;

    abstract public function processAttendance(\SimpleXMLElement|bool|null $recordsResult): array;

    abstract public function updateUsers(): void;
}
