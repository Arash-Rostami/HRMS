<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\Cr24Service;
use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;

// Import RequestOptions


class Cr24Controller extends Controller
{

    public function index(Request $request)
    {
        $account = [
            'UserName' => "Persol@A.Karimi",
            'PassWord' => "Arian1395@"
        ];

        // Correct endpoint URL based on previous successful attempts
        $url = 'https://cr24.cr24.ir/Cr24PrService.svc';

        // Define the method you are calling
        $methodName = 'LegalBankCs';


        $soapAction = 'http://tempuri.org/ICr24PrService/' . $methodName;


        $xmlBody = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <' . $methodName . ' xmlns="http://tempuri.org/">
              <accountModel>
                <UserName>' . htmlspecialchars($account['UserName']) . '</UserName>
                <PassWord>' . htmlspecialchars($account['PassWord']) . '</PassWord>
              </accountModel>
              <nationalCode>' . htmlspecialchars('0064653064') . '</nationalCode>
            </' . $methodName . '>
          </soap:Body>
        </soap:Envelope>';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => $soapAction, // Add the SOAPAction header
            ])
                ->withOptions([
                    'verify' => false, // Consider using a trusted CA bundle in production
                ])
                ->send('POST', $url, [
                    'body' => $xmlBody,
                ]);

            $statusCode = $response->status();
            $body = $response->body();

            // Check if the response is a SOAP Fault before parsing
            if ($statusCode >= 400 || str_contains($body, '<s:Fault>')) {
                // It's an error response (like the ActionNotSupported one)
                return response()->json([
                    'error' => 'SOAP Fault or HTTP Error',
                    'status' => $statusCode,
                    'body' => $body, // Return raw body to see the fault details
                ], $statusCode >= 400 ? $statusCode : 500); // Use HTTP status if it's an error, otherwise 500 for SOAP Fault
            }


            try {
                $xmlResponse = simplexml_load_string($body);


                // Returning raw XML for inspection. You'll parse this based on the service's response structure.
                return response()->json([
                    'status' => $statusCode,
                    'body' => $body, // Full XML response
                    'xml_parsed' => 'Parse the XML body here based on service response structure', // Placeholder
                ]);


            } catch (\Exception $e) {
                // Error parsing XML (if it wasn't a SOAP fault but still not valid XML)
                return response()->json([
                    'error' => 'Failed to parse XML response',
                    'message' => $e->getMessage(),
                    'body' => $body,
                ], 500);
            }

        } catch (\Exception $e) {
            // Handle cURL or other HTTP client errors
            return response()->json([
                'error' => 'HTTP Request Failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
