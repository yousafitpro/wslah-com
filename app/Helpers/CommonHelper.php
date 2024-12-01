<?php

use App\Models\Food;
use App\Models\User;
use App\Models\Language;
use App\Models\Restaurant;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\FoodCategory;
use App\Models\InstagramStory;
use Spatie\Searchable\Search;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Searchable\ModelSearchAspect;
use Symfony\Component\HttpFoundation\File\File as UFile;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\WebpEncoder;


function uploadFile($file, $path)
{

    if (isset($file)) {
        $file_name = time() . rand(1000, 9999) . "_" . $file->getClientOriginalName();
        $file_type = $file->getClientOriginalExtension();
        $file_type = strtolower($file_type);
        $explode = explode('.', $file_name);
        $ext = "." . last($explode);


        Storage::makeDirectory($path);

        //check if file type is image then do compression and convert .webp
        if(in_array($file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg', 'tiff', 'ico', 'jif', 'jfif', 'jp2', 'jpx', 'j2k', 'j2c', 'fpx', 'pcd', 'pdf', 'psd', 'ai', 'eps', 'ps', 'svgz', 'wbmp', 'avif', 'apng', 'avifs', 'heif', 'heic', 'flif', 'webp', 'avif', 'avifs', 'heif', 'heic', 'flif'])){
            array_pop($explode);
            $file_name = implode('_', $explode);
            $file_name = $path . "/" . strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $file_name)) . '.webp';

            ini_set('memory_limit', '256M');
            ini_set('max_execution_time', 300);
            $image = Image::read($file->getRealPath());
            //findout the image size
            $imageWidth = $image->width();
            $imageHeight = $image->height();
            //findout the ratio and decrease it to 80%
            $ratio = $imageWidth / $imageHeight;
            $newWidth = 800;
            $newHeight = $newWidth / $ratio;

            $image->resize($newWidth, $newHeight);
            $image->encode(new WebpEncoder(quality: 20)); // Intervention\Image\EncodedImage
            $image->save(public_path('storage/') . $file_name);

        }else{
            array_pop($explode);
            $file_name = implode('_', $explode);
            $file_name = $path . "/" . strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $file_name)) . $ext;
            Storage::put($file_name, File::get($file));
        }

        return $file_name;
    }
    return null;
}



function get_user_id_from_menu()
{
    $uuid=null;
    $rest=null;
            if (request()->has('menu') && !empty(request()->get('menu'))) {
                $uuid = request()->get('menu');
            } else {
                if (empty($request->menu) && empty($request->store_id)) {
                    if (auth()->check()) {
                        $user = auth()->user();

                        if ($user->user_type != '1' && !$user->isRest()) {
                            return redirect('home');
                        }
                        if ($user->user_type == '1') {
                            if (isset(request()->query()['uuid'])) {
                                $uuid = request()->query()['uuid'];
                            } else {
                                return redirect('home');
                            }
                        } else {
                            $uuid = $user->restaurant->uuid;
                        }
                    }
                }
            }
            if (isset(request()->query()['store_id']) || isset(request()->store_id)) {
                $rest = Restaurant::find(request()->query()['store_id']);
            }elseif($uuid){
                $rest = Restaurant::query()->where('uuid', $uuid)->first();
            }
          return $rest->user_id;
}

function instagram_stories_for_store()
{
    $user_id=get_user_id_from_menu();
    $res=Restaurant::where('user_id',$user_id)->first();
    $stories=InstagramStory::where('user_id',$user_id)->orderBy('created_at', 'desc')->limit($res->number_posts)->get();
   foreach($stories as $item)
   {
    $item->payload=json_decode($item->payload,true);
   }
    return $stories;
}

function getFileUrl($file)
{

    if ($file != null) {

        if (in_array(config('filesystems.default'), ['local', 'public'])) {
            return Storage::url($file);
        } else {
            return Storage::url($file);
        }
    }
    return null;
}



function getAllLanguages($en = false, $field = 'store_location_name')
{

    $languages = new Language();
    if (!$en)
        $languages = $languages->where('store_location_name', '!=', 'en');
    $languages = $languages->pluck('name', $field)->toArray();
    return $languages;
}

function getAllCurrentRestaruentLanguages()
{

    // $langs = auth()->user()->restaurant->language;
    // return array_intersect_key(getAllLanguages(), array_flip(array_diff(auth()->user()->restaurant->language, ['en'])));
    return getAllLanguages();
}

function getAllThemes()
{
    $themes = [
        ["name" => "Theme1", "id" => "1", "image" => '/assets/theme/theme1.png'],
        ["name" => "Theme2", "id" => "2", "image" => '/assets/theme/theme2.png'],
        ["name" => "Theme3", "id" => "3", "image" => '/assets/theme/theme3.png'],
        ["name" => "Theme4", "id" => "4", "image" => '/assets/theme/theme4.png'],
    ];
    return $themes;
}

function arrayToFileString($languageDate = [])
{
    $data = '<?php
    return
    ';
    $data .= var_export($languageDate, true) . ";";
    return $data;
}


function generateLanguageStoreDirName($languageName, $length = 2)
{
    $languageName = preg_replace('/[^a-zA-Z0-9]/i', '', $languageName);

    $genatedName = substr(strtolower($languageName), 0, $length);
    if (File::exists(lang_path($genatedName))) {
        if (strlen($languageName) >= $length) {
            return  $languageName .= "_" . time();
        }
        return  generateLanguageStoreDirName($languageName, $length + 1);
    }
    return $genatedName;
}

function getAllLanguagesFiles()
{
    $path = lang_path('en');
    $fileNames = [];
    $files = (File::allFiles($path));
    foreach ($files as $file) {
        $fileNames[pathinfo($file)['filename']] = ucfirst(pathinfo($file)['filename']);
    }

    return $fileNames + getDynamicDataTables();
}

function getDynamicDataTables()
{
    $fileNames['categories'] = "Categories";
    $fileNames['foods'] = "Foods";
    return $fileNames;
}
function getFileAllLanguagesData($file, $language = 'en', $isDot = true)
{
    $datas = Lang::get($file, [], $language);
    if ($isDot)
        return Arr::dot($datas);
    return $datas;
}

function multiArrayToDot($array)
{
    return Arr::dot($array);
}
function trimDotAndSpaces($string)
{
    return rtrim(rtrim($string, '.'), ' ');
}

function getDotStringToInputString($string, $prefix = '')
{

    if ($prefix != '') {
        $string = $prefix . "." . $string;
    }
    $array = explode('.', $string);
    if (count($array) == 1) {
        return $string;
    }
    $new = implode("][", array_slice($array, 1));
    return "{$array[0]}[$new]";
}
function readableString($str)
{
    return ucwords(str_replace("_", " ", $str));
}

function isAdmin()
{

    if(auth()->check()){
        return auth()->user()->user_type == User::USER_TYPE_ADMIN;
    }else{
        return 1;
    }
}

function getAllCurrencies()
{
    return array(
        "USD" => '$ - USD',
        "CAD" => 'CA$ - CAD',
        "EUR" => '€ - EUR',
        "AED" => 'AED - AED',
        "AFN" => 'Af - AFN',
        "ALL" => 'ALL - ALL',
        "AMD" => 'AMD - AMD',
        "ARS" => 'AR$ - ARS',
        "AUD" => 'AU$ - AUD',
        "AZN" => 'man. - AZN',
        "BAM" => 'KM - BAM',
        "BDT" => 'Tk - BDT',
        "BGN" => 'BGN - BGN',
        "BHD" => 'BD - BHD',
        "BIF" => 'FBu - BIF',
        "BND" => 'BN$ - BND',
        "BOB" => 'Bs - BOB',
        "BRL" => 'R$ - BRL',
        "BWP" => 'BWP - BWP',
        "BYN" => 'Br - BYN',
        "BZD" => 'BZ$ - BZD',
        "CDF" => 'CDF - CDF',
        "CHF" => 'CHF - CHF',
        "CLP" => 'CL$ - CLP',
        "CNY" => 'CN¥ - CNY',
        "COP" => 'CO$ - COP',
        "CRC" => '₡ - CRC',
        "CVE" => 'CV$ - CVE',
        "CZK" => 'Kč - CZK',
        "DJF" => 'Fdj - DJF',
        "DKK" => 'Dkr - DKK',
        "DOP" => 'RD$ - DOP',
        "DZD" => 'DA - DZD',
        "EEK" => 'Ekr - EEK',
        "EGP" => 'EGP - EGP',
        "ERN" => 'Nfk - ERN',
        "ETB" => 'Br - ETB',
        "GBP" => '£ - GBP',
        "GEL" => 'GEL - GEL',
        "GHS" => 'GH₵ - GHS',
        "GNF" => 'FG - GNF',
        "GTQ" => 'GTQ - GTQ',
        "HKD" => 'HK$ - HKD',
        "HNL" => 'HNL - HNL',
        "HRK" => 'kn - HRK',
        "HUF" => 'Ft - HUF',
        "IDR" => 'Rp - IDR',
        "ILS" => '₪ - ILS',
        "INR" => '₹ - INR',
        "IQD" => 'IQD - IQD',
        "IRR" => 'IRR - IRR',
        "ISK" => 'Ikr - ISK',
        "JMD" => 'J$ - JMD',
        "JOD" => 'JD - JOD',
        "JPY" => '¥ - JPY',
        "KES" => 'Ksh - KES',
        "KHR" => 'KHR - KHR',
        "KMF" => 'CF - KMF',
        "KRW" => '₩ - KRW',
        "KWD" => 'KD - KWD',
        "KZT" => 'KZT - KZT',
        "LBP" => 'L.L. - LBP',
        "LKR" => 'SLRs - LKR',
        "LTL" => 'Lt - LTL',
        "LVL" => 'Ls - LVL',
        "LYD" => 'LD - LYD',
        "MAD" => 'MAD - MAD',
        "MDL" => 'MDL - MDL',
        "MGA" => 'MGA - MGA',
        "MKD" => 'MKD - MKD',
        "MMK" => 'MMK - MMK',
        "MOP" => 'MOP$ - MOP',
        "MUR" => 'MURs - MUR',
        "MXN" => 'MX$ - MXN',
        "MYR" => 'RM - MYR',
        "MZN" => 'MTn - MZN',
        "NAD" => 'N$ - NAD',
        "NGN" => '₦ - NGN',
        "NIO" => 'C$ - NIO',
        "NOK" => 'Nkr - NOK',
        "NPR" => 'NPRs - NPR',
        "NZD" => 'NZ$ - NZD',
        "OMR" => 'OMR - OMR',
        "PAB" => 'B/. - PAB',
        "PEN" => 'S/. - PEN',
        "PHP" => '₱ - PHP',
        "PKR" => 'PKRs - PKR',
        "PLN" => 'zł - PLN',
        "PYG" => '₲ - PYG',
        "QAR" => 'QR - QAR',
        "RON" => 'RON - RON',
        "RSD" => 'din. - RSD',
        "RUB" => 'RUB - RUB',
        "RWF" => 'RWF - RWF',
        "SAR" => 'SR - SAR',
        "SDG" => 'SDG - SDG',
        "SEK" => 'Skr - SEK',
        "SGD" => 'S$ - SGD',
        "SOS" => 'Ssh - SOS',
        "SYP" => 'SY£ - SYP',
        "THB" => '฿ - THB',
        "TND" => 'DT - TND',
        "TOP" => 'T$ - TOP',
        "TRY" => 'TL - TRY',
        "TTD" => 'TT$ - TTD',
        "TWD" => 'NT$ - TWD',
        "TZS" => 'TSh - TZS',
        "UAH" => '₴ - UAH',
        "UGX" => 'USh - UGX',
        "UYU" => '$U - UYU',
        "UZS" => 'UZS - UZS',
        "VEF" => 'Bs.F. - VEF',
        "VND" => '₫ - VND',
        "XAF" => 'FCFA - XAF',
        "XOF" => 'CFA - XOF',
        "YER" => 'YR - YER',
        "ZAR" => 'R - ZAR',
        "ZMK" => 'ZK - ZMK',
        "ZWL" => 'ZW - ZWLL'
    );
}

function imageDataToCollection($fileData)
{
    // $fileData =  file_get_contents($img);
    $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
    file_put_contents($tmpFilePath, $fileData);
    $tmpFile = new UFile($tmpFilePath);

    $file = new UploadedFile(
        $tmpFile->getPathname(),
        $tmpFile->getFilename(),
        $tmpFile->getMimeType(),
        0,
        true // Mark it as test, since the file isn't from real HTTP POST.
    );
    return  $file;
}


function createQniqueSessionAndDestoryOld($key, $delete = 0)
{
    $time = time();
    if (Session::has($key)) {
        $olduniq = Session::get($key);
        Storage::deleteDirectory($olduniq);
        // destory here
    }
    if ($delete) {
        return;
    }

    Session::put($key, $time);
    return $time;
}
function moveFile($paths, $folder)
{
    $newPaths = [];
    foreach ($paths as $path) {
        $name = basename($path);
        $newPaths[] = $newPath = $folder . "/" . $name;
        Storage::move($path, $newPath);
    }
    // dd($newPaths, $paths);
    return $newPaths;
}

function globalSearch($search, $user)
{
    // dd();
    DB::enableQueryLog();
    $params = [];
    $params['restaurant_id'] = $user->restaurant->id;
    $params['lang'] = app()->getLocale();
    $restpParams['user_id'] = $user->id;
    $searchResults = (new Search())
        ->registerModel(User::class,  function (ModelSearchAspect $modelSearchAspect) use ($params) {
            $modelSearchAspect
                ->addSearchableAttribute('first_name')
                ->addSearchableAttribute('last_name')
                ->addExactSearchableAttribute('email')
                // ->addExactSearchableAttribute('phone_number')
                ->When(isset($params['restaurant_id']), function ($q) use ($params) {
                    $q->whereHas('restaurants', function ($q) use ($params) {
                        $q->where('restaurant_id', $params['restaurant_id']);
                    });
                })
                ->When(isset($params['user_id']), function ($q) use ($params) {
                    $q->where('id', '!=', $params['user_id']);
                });
        })
        ->registerModel(Restaurant::class, function (ModelSearchAspect $modelSearchAspect) use ($restpParams) {
            $modelSearchAspect
                ->addSearchableAttribute('name')
                // ->addSearchableAttribute('city')
                // ->addSearchableAttribute('state')
                // ->addSearchableAttribute('country')
                // ->addSearchableAttribute('zip')
                // ->addExactSearchableAttribute('contact_email')
                ->addExactSearchableAttribute('phone_number')
                ->when(isset($restpParams['user_id']), function ($query) use ($restpParams) {
                    $query->whereHas('users', function ($q) use ($restpParams) {
                        $q->where('user_id', $restpParams['user_id']);
                    });
                });
        })
        ->registerModel(Food::class, function (ModelSearchAspect $modelSearchAspect) use ($params) {
            $search =   $modelSearchAspect
                ->addSearchableAttribute('name')
                // ->addSearchableAttribute('description')

                // ->addSearchableAttribute('lang_description->gu')
                ->addExactSearchableAttribute('price')
                ->when(isset($params['restaurant_id']), function ($query) use ($params) {
                    $query->where("restaurant_id", $params['restaurant_id']);
                });
            if ($params['lang'] != 'en')
                $search = $search->addSearchableAttribute('lang_name->' . $params['lang']);
        })
        ->registerModel(FoodCategory::class, function (ModelSearchAspect $modelSearchAspect) use ($params) {
            $search =     $modelSearchAspect
                ->addSearchableAttribute('category_name')

                ->when(isset($params['restaurant_id']), function ($query) use ($params) {
                    $query->where("restaurant_id", $params['restaurant_id']);
                });

            if ($params['lang'] != 'en')
                $search = $search->addSearchableAttribute('lang_category_name->' . $params['lang']);
        })
        ->registerModel(Language::class, function (ModelSearchAspect $modelSearchAspect) use ($params) {
            $modelSearchAspect
                ->addSearchableAttribute('name');
        })
        ->search($search);
    return $searchResults;
}

function getInstaUsername($url)
{
    return !empty($url) ? str_replace('/', ' ', substr($url, strpos($url, "instagram.com") + 14)) : '';
}
