<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class UserLoginTest extends Controller
{
    public function test()
    {
//        $client = new Client();
//
//        // Replace with the URL of the login page
//        $loginPageUrl = 'http://85.133.210.62:8060/account/login';
//
//        // Replace with your actual username and password
//        $username = 'your_username';
//        $password = 'your_password';

        // Step 1: Request the login page and get the response body as a string
//        $response = $client->request('GET', $loginPageUrl);
//        $this->wait(3); // Wait for three seconds
//
//        $responseBody = $response->getBody()->getContents();
//
//        // Step 2: Use the wait() method to simulate the delay before crawling
//
//        // Step 3: Parse the response body to a Crawler object
//        $crawler = new Crawler($responseBody);

//        $crawler = $client->request('GET', $loginPageUrl);
//
//        // Step 2: Use the waitUntil() function to wait for five seconds
//        $crawler->waitUntil(5, function () {
//            return true; // This will cause the waitUntil() function to wait for 5 seconds
//        });
//
//        // Step 3: Find the input fields for username and password
//        $usernameField = $crawler->filter('#username')->first();
//        $passwordField = $crawler->filter('#password')->first();







        $pythonScriptPath = base_path('temp/api/test.py');
        // Execute the Python script using the exec() function
        $output = [];
        $returnCode = 0;
        exec("python {$pythonScriptPath}", $output, $returnCode);

        dd($output);

//        // Step 4: Find the input fields for username and password
//        $usernameField = $crawler->filter('#username')->first();
//        $passwordField = $crawler->filter('#password')->first();
//
//        // Step 5: Find the login button and get its "data-role" attribute
//        $loginButton = $crawler->filter('button[data-role="button"]')->first();
//        $loginButtonDataRole = $loginButton->attr('data-role');
//
//        // Step 6: Ensure we found the necessary elements
//        if ($usernameField->count() && $passwordField->count() && $loginButton->count()) {
//            // Step 7: Set the form fields with your credentials
//            $form = $usernameField->form();
//            $form->setValues(['username' => $username, 'password' => $password]);
//
//            // Step 8: Submit the form by clicking the login button
//            $client->request('POST', $form->getUri(), [
//                'form_params' => $form->getPhpValues()
//            ]);
//
//            // Step 9: You can perform additional actions on the authenticated page if needed
//            $authenticatedResponse = $client->request('GET', 'http://85.133.210.62:8060/');
//
//            // Now you can process $authenticatedResponse or $response as needed
//        } else {
//            // Elements not found or incomplete form
//        }
    }

    // Simulate a wait time in seconds
    private function wait($seconds)
    {
        sleep($seconds);
    }
}
