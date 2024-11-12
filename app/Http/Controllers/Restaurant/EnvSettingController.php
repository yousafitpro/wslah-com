<?php

namespace App\Http\Controllers\Restaurant;

use App\Events\NotificationSending;
use App\Models\Food;
use App\Models\RestaurantsIntroVideos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Validator;


class EnvSettingController extends Controller {

    public function show()
    {
        $user = auth()->user();
        if($user->hasRole('admin'))
        {
            $setting = Setting::find(1);
            $stores = Restaurant::pluck('name', 'id')->toArray();
            return view('admin.settings.create', compact('setting', 'stores'));
        } else
        {
            $restaurant = $user->restaurant;
            return view('restaurant.settings.create', [
                'row' => $restaurant,
            ]);
        }
    }

    public function updateRestaurant(Request $request)
    {
        // dd($request->get('animation_timer') .' secs');

//         $request->validate([
//             'restaurant_name' => ['required', 'string', 'min:2'],
//             'static_logo' => ['required'],
// //            'instagram_url'   => ['required', 'string', 'regex:/(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am|instagr.com)\/(\w+)/'],
//             'theme'           => ['required', 'string'],
//             'frame'           => ['required', 'string'],
//             'background'           => ['required', 'string'],
// //            'menu_title_en'   => ['required', 'string'],
// //            'menu_title_ar'   => ['required', 'string'],
//             'restaurant_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
//             'intro_video_url.*' => 'required|file',
//             'intro_video_url' => 'array|min:1|max:5',
//         ], [
//             "restaurant_logo.max"   => __('validation.gt.file', ['attribute' => 'restaurant_logo', 'value' => 10000]),
//             "restaurant_logo.image" => __('validation.enum', ['attribute' => 'restaurant_logo']),
//             "restaurant_logo.mimes" => __('validation.enum', ['attribute' => 'restaurant_logo']),
//             "theme.not_in" => 'Cannot choose white color',
//         ]);


        $validator = Validator::make($request->all(), [
            'restaurant_name'   => ['required', 'string', 'min:2'],
            // 'static_logo'       => ['required', 'image', 'max:5000'], // Assuming a max size of 5MB
            'theme'             => ['required', 'string', 'not_in:white'],
            'frame'             => ['required', 'string'],
            'background'        => ['required', 'string'],
            'restaurant_logo'   => ['nullable', 'image', 'max:10000', 'mimes:jpeg,png,jpg,gif,svg'],
            'intro_video_url.*' => ['required', 'file'],
            'intro_video_url'   => ['array', 'min:1', 'max:5'],
        ], [
            'static_logo.image'               => __('validation.image', ['attribute' => 'static_logo']),
            'static_logo.max'                 => __('validation.max.file', ['attribute' => 'static_logo', 'max' => 5000]),
            'theme.not_in'                    => __('validation.custom.theme_not_in'),
            'restaurant_logo.max'             => __('validation.max.file', ['attribute' => 'restaurant_logo', 'max' => 10000]),
            'restaurant_logo.image'           => __('validation.image', ['attribute' => 'restaurant_logo']),
            'restaurant_logo.mimes'           => __('validation.mimes', ['attribute' => 'restaurant_logo', 'values' => 'jpeg,png,jpg,gif,svg']),
            'intro_video_url.*.required'      => __('validation.required', ['attribute' => 'intro_video_url']),
            'intro_video_url.required'        => __('validation.min.array', ['attribute' => 'intro_video_url', 'min' => 1]),
            'intro_video_url.max'             => __('validation.max.array', ['attribute' => 'intro_video_url', 'max' => 5]),
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            // dd($firstError);

            $request->session()->flash('Error', __($firstError, ['model' => __('system.environment.title')]));

            return redirect()->back()->withErrors($validator)->withInput();
        }





        $data['name'] = $request->get('restaurant_name');
        $data['instagram_url'] = $request->has('instagram_url') ? $request->get('instagram_url') : '';
        $data['twitter_url'] = $request->has('twitter_url') ? $request->get('twitter_url') : '';
//        $data['script_code'] = $request->has('script_code') ? $request->get('script_code') : '';
        $data['theme'] = ($request->get('theme') == '#000000') ? '':$request->get('theme');
        $data['menu_title_en'] = $request->get('menu_title_en');
        $data['menu_title_ar'] = $request->get('menu_title_ar');
        $data['is_on_off'] = $request->get('is_on_off');
        $data['static_logo'] = $request->get('static_logo');
        $data['background_color'] = ($request->get('background') == '#000000') ? '' : $request->get('background');
        $data['frame_color'] =     ($request->get('frame') == '#000000')? '': $request->get('frame');
        $data['home_page_text'] = $request->get('home_page_text');
        $data['animation'] = $request->get('animation');
        $data['animation_timer'] = $request->get('animation_timer') .' secs';
        $data['caption_en'] = $request->get('caption_en');
        $data['social_media_icon'] = $request->get('social_media_icon');
        $data['font_color'] = $request->get('font_color');
        $data['limit_characters'] = $request->get('limit_characters');
        $data['icon_color'] = ($request->get('icon_color') == '#000000') ? '' : $request->get('icon_color');
        // vertical mode
        $data['vertical_mode'] = $request->get('vertical_mode');

        //profile_picture
        // store Restaurant Profile Picture in public folder client original and extension move public
        if($request->has('profile_picture'))
        {
            $file = $request->file('profile_picture');
            $filename = uniqid('profile_picture_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $data['profile_picture'] = $path;
            event(new NotificationSending(['type'=>'rest-setting','path'=>$path], Auth::user()->restaurant->uuid));
        }else{
            event(new NotificationSending(['type'=>'products','action'=>'new','list'=> ''], 0 ));
        }


        // $data['social_media'] = json_encode($request->get('social_media'));


//        if ($request->hasFile('intro_video_url')) {
//            $filePaths = [];
//            foreach ($request->file('intro_video_url') as $file) {
//                $filename = uniqid('intro_video_') . '.' . $file->getClientOriginalExtension();
//                $path = $file->storeAs('intro_videos', $filename, 'public');
//                $filePaths[] = $path;
//            }
//
//
//            $data['intro_video_url'] = json_encode($filePaths);
//
//
//            // Other logic or redirect as needed
//        }
        if($request->has('restaurant_logo'))
        {
            $data['logo'] = '/storage/' . uploadFile($request->restaurant_logo, 'logo');
        }

        // dd(auth()->user()->restaurant()->get());

        auth()->user()->restaurant()->update($data);

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));

        return redirect()->back();
    }

    public function updateAdmin()
    {
        $request = request();

        if(!auth()->user()->isAdmin())
        {
            // dd($request->all());
            abort(403);
        }

        $lbl_app_dark_logo = strtolower(__('system.fields.logo'));
        $lbl_app_light_logo = strtolower(__('system.fields.app_dark_logo'));
        $lbl_app_favicon_logo = __('system.fields.app_favicon_logo');
        $intro_video_url = __('system.fields.intro_video_url');

//        $request->validate([
//            'app_dark_logo'    => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
//            'app_light_logo'   => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
//            'app_favicon_logo' => ['max:10000', "image", 'mimes:jpeg,png,jpg,gif,svg'],
////            'intro_video_url' => ['required'],
//        ], [
//            "app_dark_logo.max"   => __('validation.gt.file', ['attribute' => $lbl_app_dark_logo, 'value' => 10000]),
//            "app_dark_logo.image" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),
//            "app_dark_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_dark_logo]),
//
//            "app_light_logo.max"   => __('validation.gt.file', ['attribute' => $lbl_app_light_logo, 'value' => 10000]),
//            "app_light_logo.image" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),
//            "app_light_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_light_logo]),
//
//            "app_favicon_logo.max"   => __('validation.gt.file', ['attribute' => $lbl_app_favicon_logo, 'value' => 10000]),
//            "app_favicon_logo.image" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),
//            "app_favicon_logo.mimes" => __('validation.enum', ['attribute' => $lbl_app_favicon_logo]),
//        ]);

        if($request->has('app_light_logo'))
        {
            $data['APP_LIGHT_SMALL_LOGO'] = '/storage/' . uploadFile($request->app_light_logo, 'logo');
        }

        if($request->has('intro_video_url'))
        {
            $data['INTRO_VIDEO_URL'] = $request->get('intro_video_url');
        }

        if($request->has('app_dark_logo'))
        {
            $data['APP_DARK_SMALL_LOGO'] = '/storage/' . uploadFile($request->app_dark_logo, 'logo');
        }
        if($request->has('app_favicon_logo'))
        {
            $data['APP_FAVICON_ICON'] = '/storage/' . uploadFile($request->app_favicon_logo, 'logo');
        }

        $setting = Setting::find(1);
        $setting->update(
            [
                'is_coming_soon' => $request->get('is_coming_soon'),
                'coming_soon_date' => $request->get('coming_soon_date'),
                'coming_soon_time' => $request->get('coming_soon_time'),
                'store_id' => $request->get('store_id'),
            ]
        );

        // DotenvEditor::setKeys($data)->save();
        Artisan::call('config:clear');

        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.environment.title')]));

        return redirect()->back();
    }
}
