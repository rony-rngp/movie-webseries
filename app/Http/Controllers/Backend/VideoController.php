<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\MovieAdd;
use App\Jobs\MovieUpdate;
use App\Models\Category;
use App\Models\Movie;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\TempFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class VideoController extends Controller
{
    public function show()
    {
        $videos = Movie::with('category', 'subcategory', 'sub_subcategory')->latest()->get();
        return view('backend.video.view', compact('videos'));
    }

    public function add()
    {
        $categories = Category::where('status', 1)->get();
        return view('backend.video.add', compact('categories'));
    }

    public function get_subcategory(Request $request)
    {
        $sub_categories = SubCategory::where('category_id', $request->category_id)->get();
        if ($sub_categories->count() > 0){
            return response()->json([
               'status' => true,
               'sub_categories' => $sub_categories
            ]);
        }else{
            return response()->json([
                'status' => false,
                'sub_categories' => ''
            ]);
        }
    }

    public function get_sub_subcategory(Request $request)
    {
        $sub_subcategories = SubSubCategory::where('subcategory_id', $request->subcategory_id)->get();
        if ($sub_subcategories->count() > 0){
            return response()->json([
                'status' => true,
                'sub_subcategories' => $sub_subcategories
            ]);
        }else{
            return response()->json([
                'status' => false,
                'sub_subcategories' => ''
            ]);
        }
    }

    public function video_upload(Request $request)
    {
        if ($request->isMethod('post')){
            $video = $request->file('temp_id');
            if ($video){
                $name = uniqid();
                $ext = $video->getClientOriginalExtension();
                $video_name = $name.'.'.$ext;
                $upload_path = public_path('backend/upload/video/all/');
                $video->move($upload_path, $video_name);
            }

            $temp = new TempFile();
            $temp->name = $video_name;
            $temp->save();
            return response()->json($temp->id);
        }else{
            $id = request()->getContent();
            $temp = Tempfile::findOrFail($id);
            if (file_exists(public_path('backend/upload/video/all/'.$temp->name))){
                unlink(public_path('backend/upload/video/all/'.$temp->name));
            }
            $temp->delete();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'category_id' => 'required',
           'title' => 'required',
           'description' => 'required',
            'image' => 'required|image|max:5000',
            'temp_id' => 'required'
        ]);

        //check temp_file
        $temp_file = TempFile::find($request->temp_id);

        if ($temp_file == null){
            notify()->error('Too late to submit form !', 'Error');
            return redirect()->back();
        }

        if (isset($temp_file)){
            if (!file_exists(public_path('backend/upload/video/all/'.$temp_file->name))){
                $temp_file->delete();
                notify()->error('Something want to wrong!', 'Error');
                return redirect()->back();
            }
        }

        $movie = new Movie();
        $movie->category_id = $request->category_id;
        $movie->subcategory_id = $request->subcategory_id;
        $movie->sub_subcategory_id = $request->sub_subcategory_id;
        $movie->episode = $request->episode;
        $movie->title = $request->title;
        $movie->slug = make_slug($request->title);
        $movie->description = $request->description;
        $movie->admin_id = Auth::guard('admin')->user()->id;
        $movie->active_status = 0;
        $movie->video_public_id = '';
        $movie->video_url = $request->temp_id;
        $movie->video_status = "Processing";
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/video/'.$image_name);
            Image::make($image)->resize(500,333)->save($upload_path);
            $movie->image = $image_name;
        }
        $movie->save();
        MovieAdd::dispatch($movie);
        notify()->success('Video Added', 'Success');
        return redirect()->route('admin.video.view');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $subcategories = SubCategory::where(['category_id' => $movie->category_id, 'status' => 1])->get();
        $sub_subcategories = SubSubCategory::where(['subcategory_id' => $movie->subcategory_id, 'status' => 1])->get();
        return view('backend.video.edit', compact('categories', 'subcategories', 'sub_subcategories', 'movie'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|max:5000',
        ]);

        //check temp_file
        if (!empty($request->temp_id)){
            $temp_file = TempFile::find($request->temp_id);

            if ($temp_file == null){
                notify()->error('Too late to submit form !', 'Error');
                return redirect()->back();
            }

            if (isset($temp_file)){
                if (!file_exists(public_path('backend/upload/video/all/'.$temp_file->name))){
                    $temp_file->delete();
                    notify()->error('Something want to wrong!', 'Error');
                    return redirect()->back();
                }
            }
        }


        $movie = Movie::findOrFail($id);
        $movie->category_id = $request->category_id;
        $movie->subcategory_id = $request->subcategory_id;
        $movie->sub_subcategory_id = $request->sub_subcategory_id;
        $movie->episode = $request->episode;
        $movie->title = $request->title;
        $movie->slug = make_slug($request->title);
        $movie->description = $request->description;
        $movie->admin_id = Auth::guard('admin')->user()->id;

        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/video/'.$image_name);
            Image::make($image)->resize(500,333)->save($upload_path);
            if (file_exists(public_path('backend/upload/video/'.$movie->image))){
                unlink(public_path('backend/upload/video/'.$movie->image));
            }
            $movie->image = $image_name;
        }

        //video
        if (!empty($request->temp_id)){
            $movie->video_url = $request->temp_id;
            $movie->video_status = "Processing";
        }

        $movie->save();

        if (!empty($request->temp_id)){
            MovieUpdate::dispatch($movie);
        }

        notify()->success('Video Updated', 'Success');
        return redirect()->route('admin.video.view');
    }

    public function status(Request $request)
    {
        $movie = Movie::findOrFail($request->id);
        $movie->active_status = $request->status;
        $movie->save();
        return response()->json(['status' => $movie->active_status]);
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        if (file_exists(public_path('backend/upload/video/'.$movie->image))){
            unlink(public_path('backend/upload/video/'.$movie->image));
        }
        if (!empty($movie->video_public_id)) {
            Cloudinary::destroy($movie->video_public_id, ['resource_type' => 'video']);
        }
        $movie->delete();
        notify()->success('Video Deleted', 'Success');
        return redirect()->back();
    }
}
