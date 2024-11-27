<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstagramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('instagram/accounts', [InstagramController::class, 'instagramAccounts']);
//  test return view adasd
Route::get('cache-clear', function () {
  \Artisan::call('cache:clear');
    \Artisan::call('config:cache');
    dd('cache clear');
});
Route::get('compress-all-products',[App\Http\Controllers\Restaurant\FoodController::class, 'compressAllProducts']);


Route::group(['prefix' => 'instagram'], function () {
    Route::get('login', [InstagramController::class, 'index']);
    Route::get('callback', [InstagramController::class, 'callback']);
});
Route::get('restaurants', [App\Http\Controllers\Restaurant\RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('proxy', [App\Http\Controllers\Restaurant\RestaurantController::class, 'proxy']);

Route::view('privacy-policy', 'pages.privacy-policy');
Route::view('terms-of-service', 'pages.terms-of-service');
// routes/web.php

Route::get('restaurant/{restaurant}/dashboard', [App\Http\Controllers\HomeController::class,'redirectToRestaurant'])->name('restaurant.dashboard');

Route::middleware(['preventBackHistory'])->group(function () {

    Route::get('/', [\App\Http\Controllers\MenuController::class, 'index'])->name('myrest');
    // Route::get('/admin_store_view/{uuid1?}', [\App\Http\Controllers\MenuController::class, 'index'])->name('myrest');
    Route::get('get_dynamic_data', [\App\Http\Controllers\MenuController::class, 'getDynamicData']);
    Route::get('get_foods_data', [\App\Http\Controllers\MenuController::class, 'foodData']);
    Route::get('get_video_urls', [\App\Http\Controllers\MenuController::class, 'getVideoUrls'])->name('loadVideoSlider');
    Route::get('check_coming_soon', [\App\Http\Controllers\MenuController::class, 'comingSoon'])->name('check_coming_soon');
    Route::get('coming-soon', [\App\Http\Controllers\MenuController::class, 'coming'])->name('coming');

    Auth::routes(['register' => true]);

    Route::controller(App\Http\Controllers\Restaurant\MenuController::class)->group(function () {
        //  restaurant profile
        Route::get('{restaurant}/menu', 'show')->name('restaurant.menu');
        Route::get('{restaurant}/{food_category}/menu', 'categoryItems')->name('restaurant.menu.item');
    });

    Route::put('default/{language}/languages', [App\Http\Controllers\Restaurant\LanguageController::class, 'defaultLanguage'])->name('restaurant.default.language');

    Route::get('/home/{user_id?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'default_restaurant_exists']);
    Route::post('theme_mode', [App\Http\Controllers\Controller::class, 'themeMode'])->name('theme.mode');

    Route::group(['middleware' => ["auth", "default_restaurant_exists"], 'as' => "restaurant."], function () {
        Route::post('global-search', [App\Http\Controllers\HomeController::class, 'globalSearch'])->name('global.search');
        //  Profile
        Route::controller(App\Http\Controllers\Restaurant\ProfileController::class)->group(function () {
            //  restaurant profile
            Route::get('profile', 'show')->name('profile');
            Route::get('profile/edit', 'edit')->name('profile.edit');
            Route::put('profile/update', 'update')->name('profile.update');

            //  restaurant password
            Route::get('profile/change-password', 'passwordEdit')->name('password.edit');
            Route::put('profile/password/update', 'passwordUpdate')->name('password.update');
        });

        //  restaurant user manage -- running
        Route::resource('users', App\Http\Controllers\Restaurant\UserController::class);
        Route::controller(App\Http\Controllers\Restaurant\UserController::class)->group(function () {
            Route::put('{user}/assign', 'assignRestaurant')->name('user.assign.restaurant');
        });

        // restaurant manage
        Route::resource('stores', App\Http\Controllers\Restaurant\RestaurantController::class);

//        Route::get('qr', [App\Http\Controllers\Restaurant\RestaurantController::class, 'createQR'])->name('create.QR');
//        Route::post('{restaurant}/genarteQR', [App\Http\Controllers\Restaurant\RestaurantController::class, 'genarteQR'])->name('genarteQR');

        Route::get('qr-image', [App\Http\Controllers\Restaurant\RestaurantController::class, 'getQR'])->name('get.QR');

        // set current(default) restaurant
        Route::put('default/{restaurant}/restaurant', [App\Http\Controllers\Restaurant\RestaurantController::class, 'defaultRestaurant'])->name('default.restaurant');

        // food category management
        Route::resource('food-categories', App\Http\Controllers\Restaurant\FoodCategoryController::class, [
            'except' => ['show'],
            'names'  => [
                'index'   => 'food_categories.index',
                'store'   => 'food_categories.store',
                'create'  => 'food_categories.create',
                'update'  => 'food_categories.update',
                'edit'    => 'food_categories.edit',
                'destroy' => 'food_categories.destroy',
            ]
        ]);
        Route::controller(App\Http\Controllers\Restaurant\FoodCategoryController::class)->group(function () {
            Route::post('change/position', 'positionChange')->name('food_categories.change.position');
            Route::get('add_static_data', 'add_static_data');
        });
        // restaurant videos management
        Route::controller(App\Http\Controllers\Restaurant\VideoController::class)->group(function () {
            Route::get('videos',  'index')->name('videos.index');
            Route::get('videos/create',  'create')->name('videos.create');
            Route::post('videos',  'store')->name('videos.store');
            Route::get('videos/{video}',  'show')->name('videos.show');
            Route::get('videos/{video}/edit',  'edit')->name('videos.edit');
            Route::put('videos/{video}',  'update')->name('videos.update');
            Route::delete('videos/{video}',  'destroy')->name('videos.destroy');
            Route::post('videos/update_video',  'uploadVideo')->name('videos.update_video');
            Route::post('change/position', 'positionChange')->name('video.change.position');

        });
        // food management
        Route::delete('products/all', [App\Http\Controllers\Restaurant\FoodController::class , 'deleteAll']);
        Route::resource('products', App\Http\Controllers\Restaurant\FoodController::class);
        Route::controller(App\Http\Controllers\Restaurant\FoodController::class)->group(function () {
            Route::post('food/change/position', 'positionChange')->name('foods.change.position');
            Route::post('food/update_image', 'uploadImage')->name('foods.update-image');

        });

        Route::controller(App\Http\Controllers\Restaurant\EnvSettingController::class)->group(function () {
            Route::get('environment/setting', 'show')->name('environment.setting');
            Route::get('environment/instagram-story', 'instagramStory')->name('environment.instagram_story');
            Route::put('environment/setting', 'update')->name('environment.setting.update');
            Route::put('environment/setting-rest', 'updateRestaurant')->name('environment.setting.updateRestaurant');
            Route::put('environment/setting-admin', 'updateAdmin')->name('environment.setting.updateAdmin');
        });


        Route::controller(App\Http\Controllers\Restaurant\ThemeController::class)->group(function () {
            Route::get('themes', 'index')->name('themes.index');
            Route::put('theme-update', 'update')->name('themes.update');
        });

        //Route::resource('languages', App\Http\Controllers\Restaurant\LanguageController::class, ['except' => ['show']]);
        Route::group(['prefix' => 'social', 'as' => 'instagram.'], function () {
            Route::get('login', [InstagramController::class, 'index'])->name('login');
            Route::get('callback', [InstagramController::class, 'callback'])->name('callback');
        });
    });

    Route::get('dev_logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});
Route::group(['middleware' => ["auth", "default_restaurant_exists"], 'as' => "restaurant."], function () {
    Route::controller(App\Http\Controllers\Restaurant\LanguageController::class)->group(function () {
        Route::get('export-sample', 'sampleDownload')->name('languages.export.sample');
        Route::post('import-sample', 'sampleImport')->name('languages.import.sample');
    });
});


Route::middleware(['web'])->group(function () {
    // Your regular user routes go here

    Route::prefix('admin')->group(function () {
        // Your admin panel routes go here

        Route::middleware(['admin'])->group(function () {
            // Your admin-specific routes go here

            Route::get('/login-as-user/{userId}', [HomeController::class, 'loginAsUser'])->name('login-as-user');
        });

        // Route::get('/logout-as-user', [HomeController::class, 'logoutAsUser'])->name('logout-as-user')->middleware('auth');
        Route::get('/logout-as-user', [HomeController::class, 'logoutAsUser'])->name('logout-as-user');

    });
});


