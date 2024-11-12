<?php

namespace App\Http\Controllers\Restaurant;

use App\Events\NotificationSending;
use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\FoodRequest;
use App\Models\Food;
use App\Repositories\Restaurant\FoodRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

            $request = request();
            $user = auth()->user();

            $params = $request->only('par_page', 'sort', 'direction', 'filter', 'food_category_id');
            // $par_page = 10;
            // if (in_array($request->par_page, [10, 25, 50, 100])) {
            //     $par_page = $request->par_page;
            // }
            // $params['par_page'] = $par_page;

            if ($user->hasRole('admin')) {
                $params['restaurant_id'] = null;
            } else {
                $params['restaurant_id'] = $user->restaurant_id;
            }
            $foods = (new FoodRepository())->getUserRestaurantFoods($params);
//            dd($foods);
        return view('restaurant.foods.index', ['foods' => $foods]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->isRest()){
            abort(403);
        }


        return view('restaurant.foods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        foreach($request->gallery_image as $key => $food_image){ // based on gallery create separate products
            DB::beginTransaction();
            $input = [
                "is_display" => $request->is_display,
                "food_image" => $food_image,
                "restaurant_id" => $request->restaurant_id,
                "name" => $request->name ?? '',
                "price" => $request->price,
                "is_available" => $request->is_available,
          ];

          createQniqueSessionAndDestoryOld('unique', 1);
          $categories = $request->categories;
          try {
              $food = Food::create($input);
              DB::commit();
          } catch (\Exception $e)
          {
              DB::rollback();
              dd($e->getMessage());
          }

          if($food->is_available){
            //set redis cache
            Redis::del('foodData:' . $food->restaurant->uuid);
              event(new NotificationSending(['type'=>'products','action'=>'new','list'=>$food], Auth::user()->restaurant->uuid));
              event(new NotificationSending(['type'=>'products','action'=>'new','list'=>$food], 0));
          }
        }//end foreach

        return redirect()->route('restaurant.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(food $product)
    {
        if (($redirect = $this->checkRestaurantIsValidFood($product)) != null) {

            return redirect($redirect);
        }
        return view('restaurant.foods.view', ['food' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(food $product)
    {
        if (($redirect = $this->checkRestaurantIsValidFood($product)) != null) {
            return redirect($redirect);
        }
        return view('restaurant.foods.edit', ['food' => $product]);
    }

    public function checkRestaurantIsValidFood($food)
    {
        $user = auth()->user();
        $params['restaurant_id'] = $user->restaurant_id;
        $params['id'] = $food->id;

        $food = (new FoodRepository())->getUserRestaurantFood($params);
        if (empty($food)) {
            $back = request()->get('back', route('restaurant.products.index'));
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.foods.title')]));

            return $back;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(FoodRequest $request, food $product)
    {
        $is_available  =  $product->is_available;
        if (($redirect = $this->checkRestaurantIsValidFood($product)) != null) {
            return redirect($redirect);
        }

        $categories = $request->categories;

        $data = $request->only('restaurant_id', 'food_category_id', 'name', 'description', 'price', 'preparation_time', 'is_featured', 'is_available', 'is_out_of_sold', 'ingredient', 'food_image', 'label_image', 'lang_name', 'lang_description', 'gallery_images','is_display');
        if(filled($request->gallery_image))
        $data['food_image'] = $request->gallery_image[0];
        $data['is_display'] = (int)$request->is_display;

    createQniqueSessionAndDestoryOld('unique', 1);
//    $addData = array_diff($categories, $product->categories_ids);
//    $deleted = array_diff($product->categories_ids, $categories);
//dd($product,$data);
        Food::where('id',$product->id)->update($data);
//        $food->fill($data)->save();



    //    $ids = DB::table('food_food_category')->where('food_id', $food->id)->whereIn('food_category_id', $deleted)->delete();
        $inserts = [];
//        foreach ($addData as $category) {
//            $inserts[] = ['food_category_id' => $category, 'food_id' => $food->id];
//        }
//        DB::table('food_food_category')->insert($inserts);

//        $request->session()->flash('Success', __('system.messages.updated', ['model' => __('system.foods.title')]));
//
//        if ($request->back) {
//            // dd($request->back);
//            return redirect($request->back);
//        }
        $product = Food::find($product->id);
        $status = 'update';
        if($is_available == 0 && $product->is_available == 1){
            $status = 'new';
        }
        elseif($is_available == 1 && $product->is_available == 0){
            $status = 'delete';
        }
        event(new NotificationSending(['type'=>'products','action'=>$status,'list'=>Food::find($product->id)], Auth::user()->restaurant->uuid));
        event(new NotificationSending(['type'=>'products','action'=>$status,'list'=>Food::find($product->id)],0));
        return redirect(route('restaurant.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(food $product)
    {
        $request = request();
        if (($redirect = $this->checkRestaurantIsValidFood($product)) != null) {
            return redirect($redirect);
        }

        event(new NotificationSending(['type'=>'products','action'=>'delete','list'=>Food::find($product->id)], Auth::user()->restaurant->uuid));
        event(new NotificationSending(['type'=>'products','action'=>'delete','list'=>Food::find($product->id)], 0));

        //delete product image from storage
        $food_image_path = \Storage::path($product->food_image);
        if (file_exists($food_image_path)) {
            unlink($food_image_path);
        }


        //clear Redis cache
        Redis::del('foodData:' . $product->restaurant->uuid);

        $product->delete();


        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.foods.title')]));

        if ($request->back) {
            return redirect($request->back);
        }

        return redirect(route('restaurant.products.index'));
    }

    public function deleteAll()
    {
        $request = request();
        $user = auth()->user();
        $restaurant_id = $user->restaurant_id;
        //clear Redis cache
        Redis::del('foodData:' . $user->restaurant->uuid);

        $foods = Food::where('restaurant_id', $restaurant_id)->get();
        foreach ($foods as $product) {

            event(new NotificationSending(['type'=>'products','action'=>'delete','list'=>Food::find($product->id)], Auth::user()->restaurant->uuid));
            event(new NotificationSending(['type'=>'products','action'=>'delete','list'=>Food::find($product->id)], 0));

            //delete product image from storage
            $food_image_path = \Storage::path($product->food_image);
            if (file_exists($food_image_path)) {
                unlink($food_image_path);
            }

            //clear Redis cache
            Redis::del('foodData:' . $product->restaurant->uuid);

            $product->delete();



        }


        $request->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.foods.title')]));
        return redirect(route('restaurant.products.index'));
    }
    public function positionChange()
    {
        $request = request();

        $foodCategory = DB::table('food_food_category')->where('food_id', $request->food_id)->where('food_category_id', $request->category)->update(['sort_order' => $request->index]);
        return true;
    }
    public function uploadImage()
    {
        $request = request();
        $file = $request->file('file');
        $unique = 'food_image';
        $upload_name = uploadFile($file, $unique);
        $name =  basename($upload_name);
        $newFileName = substr($name, 0, (strrpos($name, ".")));
        return ['data' => ['name' => $name, "id" => $newFileName, 'upload_name' => $upload_name]];
    }

    //this method is for testing purpose compressAllProducts
    public function compressAllProducts()
    {
        $foods = Food::all();
        foreach ($foods as $food) {
           try {
            //make storage file to request file
            $food_image_path = \Storage::path($food->food_image);
            // check if $food->food_image contain /food_image/ then remove it
            // if (strpos($food->food_image, '/food_image/') == false) {
            //     $food_image_path =  $food_image_path = storage_path('app/public/food_image/' . $food->food_image);
            // }
              //check if file extension is not .webp then compress it
            $file_image_ext = explode('.', $food->food_image);
           if($file_image_ext[1] != 'webp'){
                $food_image_file = new \Illuminate\Http\UploadedFile($food_image_path, $food->food_image, mime_content_type($food_image_path), null, true);
               //call uploadFile method to compress image and save it
                $upload_name = uploadFile($food_image_file, 'food_image');

                $food->food_image = $upload_name;
                $food->save();
            }
           } catch (\Throwable $th) {
                // dd($th->getMessage());
                \Log::info('Error in compressing food image: ' . $food->id . ' ' . $th->getMessage());
           }

        }
        dd('done');
    }
}
