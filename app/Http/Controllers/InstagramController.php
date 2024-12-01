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

        Restaurant::where('user_id',auth()->user()->id)->update([
            'instagram_token'=>$response_data['access_token'],
            'fb_user'=>json_encode($this->userInfo($response_data['access_token']))
        ]);
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
    public function getIstagramAccount($token,$page_id)
    {
        dump("Page ID",$page_id);
        $access_token =$token; // From previous step

        // Get connected Instagram account
        $ch = curl_init("https://graph.facebook.com/v19.0/{$page_id}?fields=connected_instagram_account&access_token={$access_token}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $instagram_data = json_decode($response, true);

        $ig_user_id = $instagram_data['connected_instagram_account']['id'];
        $this->getInstagramStories($ig_user_id,$token);
    }
    public function getInstagramReels($ig_user_id,$access_token){
        dump("instgram User ID",$ig_user_id);
        $ch = curl_init("https://graph.facebook.com/v19.0/{$ig_user_id}/media?fields=id,media_type,media_url,caption,timestamp&access_token={$access_token}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $media = json_decode($response, true);
        // Filter for Reels (Reels are 'VIDEO' type with additional checks)
        $reels = array_filter($media['data'], function($item) {
            return $item['media_type'] === 'VIDEO'; // Reels are returned as 'VIDEO'
        });

        dd($reels);

    }
    public function getInstagramStories($ig_user_id, $access_token) {
        // Limit to 10 stories
        $url = "https://graph.facebook.com/v19.0/{$ig_user_id}/stories?fields=id,media_type,media_url,thumbnail_url,timestamp&limit=10&access_token={$access_token}";

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute request and close cURL
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $stories = json_decode($response, true);

        dd($stories);  // Display the latest 10 Stories
    }
    public function instagramAccounts()
    {
        $restaurant=Restaurant::where('user_id',auth()->user()->id)->first();
        $token = $restaurant->instagram_token;
        $access_token = $token; // From previous step
        $ch = curl_init("https://graph.facebook.com/v10.0/me/accounts?access_token=$access_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $pages = json_decode($response, true);
  // Look for the 'id' of the connected page
        $page_access_token=$pages['data'][0]['access_token'];
        $page_id=$pages['data'][0]['id'];
        $this->getIstagramAccount($page_access_token,$page_id);
    }


}
