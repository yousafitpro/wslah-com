<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest; // Create a VideoRequest class for validation
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('sort_order')
            ->where('restaurant_id', Auth::user()->restaurant_id)
            ->paginate(9);

        return view('restaurant.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('restaurant.videos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $video = Video::create([
            'file' => $request->file,
            'sort_order' => Video::max('sort_order') + 1,
            'restaurant_id' => Auth::user()->restaurant_id,
        ]);

        Session::flash('success', __('system.messages.saved', ['model' => __('system.videos.title')]));
        return redirect()->route('restaurant.videos.index');
    }

    public function edit(Video $video)
    {
        return view('restaurant.videos.edit',compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $video->update([
            'file' => $request->file,
        ]);

        Session::flash('success', __('system.messages.change_success_message', ['model' => __('system.videos.title')]));
        return redirect()->route('restaurant.videos.index');
    }

    public function destroy(Video $video)
    {
        //unlink the file
        $file_path = \Storage::path($video->file);
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $video->delete();

        Session::flash('success', __('system.messages.deleted', ['model' => __('system.videos.title')]));
        return redirect()->route('restaurant.videos.index');
    }

     public function uploadVideo()
    {
        $request = request();
        $file = $request->file('file');
        $unique = 'videos';
        $upload_name = uploadFile($file, $unique);
        $name =  basename($upload_name);
        $newFileName = substr($name, 0, (strrpos($name, ".")));
        return ['data' => ['name' => $name, "id" => $newFileName, 'upload_name' => $upload_name]];
    }
}
