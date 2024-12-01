<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Amirsarhang\Instagram;
use App\Models\InstagramStory;

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

    public function sotry_seting_update(Request $request)
    {
        Restaurant::where('user_id',auth()->id())->update([
            'animation_type'=>$request->animation_type,
            'number_posts'=>$request->number_posts,
            'animation_duration'=>$request->animation_duration=='0'?1:$request->animation_duration,
        ]);
        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.restaurants.title')]));
        try{
            $this->instagramAccounts();
        }
        catch(\Exception $e){

        }
        return redirect(url('environment/instagram-story'));
    }
    public function sotry_seting()
    {
        $restaurant=Restaurant::where('user_id',auth()->id())->first();
          return view('instagram.story.story_setting')->with(['restaurant'=>$restaurant]);
    }
    public function exchangeToken($user_id)
    {
        $client_id = config('services.fb.app_id');
        $client_secret = config('services.fb.secret');
        $restaurant=Restaurant::where('user_id',$user_id)->first();
        $short_lived_token = $restaurant->instagram_token;
           // Exchange short-lived token for a long-lived token
            $long_lived_url = "https://graph.facebook.com/v10.0/oauth/access_token?"
            . "grant_type=fb_exchange_token"
            . "&client_id={$client_id}"
            . "&client_secret={$client_secret}"
            . "&fb_exchange_token={$short_lived_token}";

            $ch = curl_init($long_lived_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $long_lived_response = curl_exec($ch);
            curl_close($ch);

            // Decode the long-lived token response
            $long_lived_data = json_decode($long_lived_response, true);
            $long_lived_token = $long_lived_data['access_token'];
            dump( $long_lived_token);
            Restaurant::where('user_id', $user_id)->update([
                'instagram_token' => $long_lived_token
            ]);
            $long_lived_token = $long_lived_data['access_token'];
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
        try{
            $this->instagramAccounts();
        }
        catch(\Exception $e){

        }
        return redirect(url('instagram/story-setting'));
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
    public function getIstagramAccount($token,$page_id,$user_id)
    {

        $access_token =$token; // From previous step

        // Get connected Instagram account
        $ch = curl_init("https://graph.facebook.com/v19.0/{$page_id}?fields=connected_instagram_account&access_token={$access_token}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $instagram_data = json_decode($response, true);

        $ig_user_id = $instagram_data['connected_instagram_account']['id'];
        $this->getInstagramStories($ig_user_id,$token,$user_id);
    }
    public function getInstagramReels($ig_user_id,$access_token,$user_id){

        $ch = curl_init("https://graph.facebook.com/v19.0/{$ig_user_id}/media?fields=id,media_type,media_url,caption,timestamp&access_token={$access_token}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $media = json_decode($response, true);
        // Filter for Reels (Reels are 'VIDEO' type with additional checks)
        $reels = array_filter($media['data'], function($item) {
            return $item['media_type'] === 'VIDEO'; // Reels are returned as 'VIDEO'
        });
        $this->saveReelsToDatabase($reels['data'],$user_id);

    }
    public function saveReelsToDatabase($data,$user_id) {
     foreach( $data as $item)
     {
        InstagramStory::updateOrCreate(['insta_story_id'=>$item['id'],'user_id'=>$user_id],
        [
            'insta_story_id'=>$item['id'],
            'user_id'=>$user_id,
            'payload'=>json_encode($item),
            ]
     );
     }
    }
    public function getInstagramStories($ig_user_id, $access_token,$user_id) {
        $res=Restaurant::where('user_id',$user_id)->first();
        $numer_of_posts=10;
        if(!empty($res->number_posts) && $res->number_posts>0)
        {
            $numer_of_posts=$res->number_posts;
        }
        // Limit to 10 stories
        $url = "https://graph.facebook.com/v19.0/{$ig_user_id}/stories?fields=id,media_type,media_url,thumbnail_url,timestamp&limit={$numer_of_posts}&access_token={$access_token}";

        // Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute request and close cURL
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $stories = json_decode($response, true);

        $this->saveReelsToDatabase($stories['data'],$user_id);
    }
    public function instagramAccounts($user_id=null)
    {
        if($user_id==null)
        {
            $user_id=auth()->user()->id;
        }
        $restaurant=Restaurant::where('user_id',$user_id)->first();
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
        $this->getIstagramAccount($page_access_token,$page_id,$user_id);
    }
    public function instagramAccountsFetchStoriesJob()
    {
       $res= Restaurant::all();
       foreach($res as $item)
       {
        try{
            $this->instagramAccounts($item->user_id);
        }catch(\Exception $e){}
       }
    }
    public function instagramAccountsExchangeTokensJob()
    {
       $res= Restaurant::all();
       foreach($res as $item)
       {
        try{
            $this->exchangeToken($item->user_id);
        }catch(\Exception $e){}
       }
    }

}
