<?php

namespace App\Http\Controllers;

use App\Models\InstagramStory;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\Setting;
use App\Models\Video;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;


class MenuController extends Controller
{


    // comingSoon
    public function comingSoon()
    {
        $setting = Setting::find(1);
        if ($setting->is_coming_soon == 1) {
            $date = $setting->coming_soon_date;
            $time = $setting->coming_soon_time;
            $date = $date . ' ' . $time;
            $date = new DateTime($date);
            $store_id = $setting->store_id;
            // id admin
            // $date->add(new DateInterval('PT1H'));
            $now = now();
            if ($date > $now && $setting->is_coming_soon == 1) {
                $url = route('coming') . '?' . http_build_query(['store_id' => $store_id]);
                // return response json true and also use datetime which I will use in jquery to show a countdown
                return response()->json(['status' => true, 'date' => $date, 'store_id' => $store_id, 'url' => $url, 'is_admin' => isAdmin()]);
            }
        }

        return response()->json(['status' => false, 'is_admin' => isAdmin()]);
    }

    public function coming(Request $request)
    {
        $uuid = $request->query()['store_id'];

        $rest = Restaurant::where('uuid',$uuid)->first();

        if (empty($rest)) {
            abort(404);
        }

        $primaryColor = !empty($rest->theme) ? $rest->theme : "#821379";
        $backgroundColor = empty($rest->background_color) ? "linear-gradient(to right, #f0eabe, #bfead7)" : $rest->background_color;
        $frameColor = empty($rest->frame_color) ? "#ffffff" : $rest->frame_color;
        $fontColor = empty($rest->font_color) ? "#ffffff" : $rest->font_color;

        // Prepare the data to return
        $data = [
            'primary_color' => $primaryColor,
            'background_color' => $backgroundColor,
            'frame_color' => $frameColor,
            'font_color' => $fontColor,
            // Include other necessary data here...
        ];

        // Return the data as JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json($data);
        }

        $video_id = $rest->id;


        $intro_video_url = Video::where('restaurant_id', $video_id)->orderBy('sort_order')->get();

        return view('menu.index', [
            'logo'            => $rest->logo,
            'foods'           => $rest->foods()->where('foods.is_available', 1)->get(),
            'menu_title'      => [
                'en' => $rest->menu_title_en,
                'ar' => $rest->menu_title_ar,
            ],

            'intro_video_url' => $intro_video_url,
            'script_code'    => $rest->script_code,
            'rest' => $rest,
            'is_vertical' => $rest->vertical_mode,
            'animation_timer' => (int)$rest->animation_timer * 1000,
            'font_color' => $fontColor
        ]);
    }

    public function index(Request $request)
    {
        // dd(\Hash::make('12121212'));
        if ($request->has('menu') && !empty($request->get('menu'))) {
            $uuid = $request->get('menu');
        } else {
            if (empty($request->menu) && empty($request->store_id)) {
                if (auth()->check()) {
                    $user = auth()->user();

                    if ($user->user_type != '1' && !$user->isRest()) {
                        return redirect('home');
                    }
                    if ($user->user_type == '1') {
                        if (isset($request->query()['uuid'])) {
                            $uuid = $request->query()['uuid'];
                        } else {
                            return redirect('home');
                        }
                    } else {
                        $uuid = $user->restaurant->uuid;
                    }
                } else {
                    return redirect('login');
                }
            }
        }
        if (isset($request->query()['store_id']) || isset($request->store_id)) {
            $rest = Restaurant::find($request->query()['store_id']);
        }else{
            $rest = Restaurant::query()->where('uuid', $uuid)->first();
        }

        if (empty($rest)) {
            abort(404);
        }

        //        $rest->theme = "#824a7e";

        //        $intro_video_url = !empty($rest->intro_video_url) ? $rest->intro_video_url : config('app.intro_video_url');
        // Process the conditions
        $primaryColor = !empty($rest->theme) ? $rest->theme : "#821379";
        $backgroundColor = empty($rest->background_color) ? "linear-gradient(to right, #f0eabe, #bfead7)" : $rest->background_color;
        $frameColor = empty($rest->frame_color) ? "#ffffff" : $rest->frame_color;
        $fontColor = empty($rest->font_color) ? "#ffffff" : $rest->font_color;

        // Prepare the data to return
        $data = [
            'primary_color' => $primaryColor,
            'background_color' => $backgroundColor,
            'frame_color' => $frameColor,
            'font_color' => $fontColor,
            'animation_timer' => (int)$rest->animation_timer * 1000,
            // Include other necessary data here...
        ];

        // Return the data as JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json($data);
        }

        if (!empty(auth()->user()) && auth()->user()->user_type == 1) {
            $video_id = auth()->user()->restaurant_id;
        } else {
            $video_id = $rest->id;
        }

        $intro_video_url = Video::where('restaurant_id', $video_id)->orderBy('sort_order')->get();
          $stories_count=InstagramStory::where('user_id',$rest->user_id)->count();
        return view('menu.index', [
            'logo'            => $rest->logo,
            'foods'           => $rest->foods()->where('foods.is_available', 1)->get(),
            'menu_title'      => [
                'en' => $rest->menu_title_en,
                'ar' => $rest->menu_title_ar,
            ],

            'intro_video_url' => $intro_video_url,
            'script_code'    => $rest->script_code,
            'stories_count'=>$stories_count,
            'rest' => $rest,
            'is_vertical' => $rest->vertical_mode,
            'animation_timer' => (int)$rest->animation_timer * 1000,
            'font_color' => $fontColor,
            'primary_color'=> $primaryColor,
        ]);
    }

    public function getVideoUrls(Request $request)
    {
        $uuidData = Restaurant::where('uuid', $request->uuid)->first();
            $uuid = $uuidData->id;
        $intro_video_url = Video::where('restaurant_id', $uuid)->orderBy('sort_order')->get();

        return view('menu.partials.video-slider')->with('intro_video_url', $intro_video_url);

        return $intro_video_url;
    }
    public function getDynamicData(Request $request)
    {
        $uuid = $request->input('uuid');
        $rest = Restaurant::query()->where('uuid', $uuid)->first();

        if (empty($rest)) {
            return response()->json(['error' => 'Restaurant not found'], 404);
        }

        $currentTime = [
            'hour' => date("h", time()),
            'time12' => date("A", time()),
            'minutes' => date("i", time()),
        ];
        if (strpos($rest->social_media_icon, 'twitter') !== false) {
            $basePath = "";
        } else {
            $basePath = "";
        }
        $coneDescData = [
            'home_page_text' => $rest->home_page_text ?? 'شاركنا لحظاتك',
            'instagram_url' => $basePath . $rest->instagram_url,
            'social_media' => $rest->instagram_url,
            'twitter_url' => $rest->twitter_url,
            'social_media_icon' => $rest->social_media_icon,
            'name' => $rest->name,
            'font_color' => $rest->font_color,
            'icon_color' => $rest->icon_color,
            'en_caption' => $rest->caption_en ?? 'Share your moments with us',
        ];
        // dd(1);

        $data = [
            'logo' => $rest->logo,
            'vertical_mode' => $rest->vertical_mode,
            'profile_picture' => asset('storage/' . $rest->profile_picture),
            'animation_timer' => (int)$rest->animation_timer * 1000,
            'menu_title' => [
                'en' => $rest->menu_title_en,
                'ar' => $rest->menu_title_ar,
            ],
            'is_on_off' => $rest->is_on_off,
            'date' => __('days.' . strtolower(date('D'))) . ' ' . date('d') . ' ' . __('months.' . strtolower(date('M'))) . ' ' . date('Y'),
            'time' => $currentTime,
            'static_logo' => $rest->static_logo ?? '',
            'script_code' => $rest->script_code ?? '',
            'cone_desc' => $coneDescData,

        ];

        return response()->json($data);
    }





    public function foodData(Request $request)
    {
        $cacheKey = 'foodData:' . $request->uuid;

        // Check if data exists in cache
        if (Redis::exists($cacheKey)) {
            $cachedData = Redis::get($cacheKey);
            return json_decode($cachedData, true);
        }

        $rest = Restaurant::query()->where('uuid', $request->uuid)->first();
        $foods = $rest->foods()->where('foods.is_available', 1)->get();

        // Cache the data for future use
        Redis::set($cacheKey, json_encode([
            'foods' => $foods,
            'rest' => $rest,
        ]));

        // Set expiration time for cache (e.g., 1 hour)
        Redis::expire($cacheKey, 36);

        return [
            'foods' => $foods,
            'rest' => $rest,
        ];
    }
}
