<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Amirsarhang\Instagram;

class InstagramController extends Controller
{
    public function index()
    {
        // $permissions = [
        //     'email',
        //     'public_profile',
        //     'instagram_basic',
        //     'instagram_manage_insights',
        //     'pages_read_engagement',
        //     'pages_show_list',
        //     'instagram_manage_comments',
        //     'instagram_manage_messages',
        //     'pages_manage_engagement',
        //     'pages_manage_metadata'
        // ];
          $permissions = [
            'instagram_basic',
            'pages_show_list',
            'instagram_manage_comments',
            'instagram_manage_messages',
            'pages_manage_engagement',
            'pages_read_engagement',
            'pages_manage_metadata'
        ];

        // Generate Instagram Graph Login URL
        $login = (new Instagram())->getLoginUrl($permissions);

        // Redirect To Facebook Login & Select Account Page
        return redirect()->to($login);
    }

    public function callback()
    {
        $client_id = config('servcies.fb.app_id');
        $client_secret = config('servcies.fb.secret');
        $redirect_uri = config('servcies.fb.callback_url'); // The same as the redirect URI used in authorization
        $code = $_GET['code']; // The code from the URL
dd($client_id,$client_secret,$redirect_uri,$code);
        // Prepare the data to be sent
        $data = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_uri,
            'code' => $code
        );

        // Initialize cURL session
        $ch = curl_init('https://api.instagram.com/oauth/access_token');

        // Set the cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Execute cURL and get the response
        $response = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        // Decode the response
        $response_data = json_decode($response, true);

        if (isset($response_data['access_token'])) {
            // Access token is available
            echo "Access Token: " . $response_data['access_token'];
        } else {
            // Error handling if token is not returned
            echo "Error: " . $response_data['error_message'];
        }

    }
    //  public function callback()
    // {
    //     return Instagram::getUserAccessToken();
    // }

    public function instagramAccounts(): array
    {
        $token = "<USER_ACCESS_TOKEN>"; // We got it in callback
        $instagram = new Instagram($token);

        // Will return all instagram accounts that connected to your facebook selected pages.
        return $instagram->getComment();
    }
}
