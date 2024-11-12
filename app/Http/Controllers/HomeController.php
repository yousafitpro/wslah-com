<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use App\Models\User;
use App\Repositories\Restaurant\FoodCategoryRepository;
use App\Repositories\Restaurant\FoodRepository;
use App\Repositories\Restaurant\RestaurantRepository;
use App\Repositories\Restaurant\UserRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Auth;

class HomeController extends Controller {

    private $originalAdminUser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
 
        $user = auth()->user();
        $restaurant = $user->restaurant;
        $params = [];
        if($user->user_type != User::USER_TYPE_ADMIN){
            $params['user_id'] = $user->id;
        }
        $data['user'] = $user;

        if($user->hasRole('admin')){
//            $data['restaurants_count'] = (new RestaurantRepository())->getCountRestaurants($params);

            $data['users_count'] = (new UserRepository())->getRestaurantsCount();
            $data['categories_count'] = (new FoodCategoryRepository)->getCountRestaurantFoodCategories();
            $data['foods_count'] = (new FoodRepository())->getUserRestaurantFoodCount();

            $data['restaurants'] = (new RestaurantRepository())->getUserRestaurantsDetails(['latest' => 1, 'recodes' => 6]);
//            $data['users'] = (new UserRepository())->getRestaurantUsersRecodes(['user_id' => $user->id, 'recodes' => 6]);
            $data['categories'] = (new FoodCategoryRepository)->getRestaurantCategories(['recodes' => 6]);
            $data['foods'] = (new FoodRepository)->getUserRestaurantFoodsCustome(['recodes' => 6]);
        }else{
            $data['categories_count'] = (new FoodCategoryRepository)->getCountRestaurantFoodCategories(['restaurant_id' => $restaurant->id]);
            $data['foods_count'] = (new FoodRepository())->getUserRestaurantFoodCount(['restaurant_id' => $restaurant->id]);

            $data['categories'] = (new FoodCategoryRepository)->getRestaurantCategories(['restaurant_id' => $restaurant->id, 'recodes' => 6]);
            $data['foods'] = (new FoodRepository)->getUserRestaurantFoodsCustome(['restaurant_id' => $restaurant->id, 'recodes' => 6]);
        }

        return view('dashboard.index', $data);
    }

    public static function getCurrentUsersAllRestaurants()
    {
        $user = auth()->user();
        $params = [];
        if($user->user_type != User::USER_TYPE_ADMIN)
        {
            $params['user_id'] = $user->id;
        }

        return (new RestaurantRepository())->getUserRestaurantsDetails($params);
    }


    public function globalSearch()
    {
        $request = request();
        $search = [];
        if(strlen($request->search) > 2)
        {
            $search = globalSearch($request->search, $request->user());
        }

        return view('layouts.search')->with('search', $search);
    }

    // admin to user login
    // ...

    public function loginAsUser($userId)
    {
        // Ensure the logged-in user is an admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        Session::put('adminLoggedInAsUser', true);
        Session::put('originalAdminUserId', auth()->user()->id);

        $user = User::findOrFail($userId);
        Auth::loginUsingId($user->id);

        return redirect('/home');


        // Find the user by ID
        // $userToLogin = User::find($userId);


        // Log in as the user
        // auth()->login($userToLogin);

        // Redirect to the user's dashboard or any other desired page
    }

    public function logoutAsUser()
    {
        $originalAdminUserId = Session::get('originalAdminUserId');
        if (!$originalAdminUserId) {
            abort(403, 'Unauthorized action.');
        }

        Auth::loginUsingId($originalAdminUserId);

        Session::forget('adminLoggedInAsUser');
        Session::forget('adminLoggedInAsUser');
        return redirect('/home');


        if ($originalAdminUserId) {
            // Log out the current user (the impersonated user)

            // Log back in as the original admin user
            $this->originalAdminUser = User::find($originalAdminUserId);

            if ($this->originalAdminUser && Session::get('originalAdminUserId') && Session::get('adminLoggedInAsUser')) {
                auth()->logout();

                if ($this->originalAdminUser->isAdmin()) {
                    // Remove the session variable
                    Session::forget('originalAdminUserId');
                    Session::forget('adminLoggedInAsUser');
                    auth()->login($this->originalAdminUser);
                    return redirect('/home');
                }
            }
        }
        abort(403, 'Unauthorized action.');
    }
}
