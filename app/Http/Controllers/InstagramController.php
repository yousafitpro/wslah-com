<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
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
        $request = request();
        $client_id = config('services.fb.app_id');
        $client_secret = config('services.fb.secret');
        $redirect_uri = config('services.fb.callback_url');

        $code = $_GET['code'];

        // Prepare the data to be sent
        $data = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_uri,
            'code' => $code
        );

        // Initialize cURL session
        $ch = curl_init('https://graph.facebook.com/v10.0/oauth/access_token');

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

        Restaurant::where('user_id',auth()->user()->id)->update(['instagram_token'=>$response_data['access_token']]);
        $request->session()->flash('Success', __('system.messages.change_success_message', ['model' =>"Successfully Connected"]));

        return redirect(route('restaurant.environment.instagram_story'));
    }
    //  public function callback()
    // {
    //     return Instagram::getUserAccessToken();
    // }
    public function userInfo($access_token)
    {

        $instagram = new Instagram($access_token);

        $endpoint = '/me?fields=id,name';

        return $instagram->get($endpoint);

    }
    public function instagramAccounts()
    {
        $restaurant=Restaurant::where('user_id',auth()->user()->id)->first();
        $token = $restaurant->instagram_token;
        $access_token = $token; // From previous step
        dd($this->userInfo($token));
        $ch = curl_init("https://graph.facebook.com/v19.0/me/accounts?access_token=$access_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $pages = json_decode($response, true);
        dd($pages);  // Look for the 'id' of the connected page
        $instagram = new Instagram($token);

        // Will return all instagram accounts that connected to your facebook selected pages.
        $accounts=$instagram->getConnectedAccountsList();
        dd( $accounts);
    }
}
