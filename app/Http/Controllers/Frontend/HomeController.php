<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Cms;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->where('status', 1)->latest()->get();
        $data['meta_title'] = 'Movie & Web Website';
        $data['meta_keywords'] = 'Movie, Web Series, Video' ;
        $data['meta_description'] = 'Movie Show and Download website';
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        return view('frontend.home', compact('categories'), $data);
    }

    public function subcategory($id, $slug)
    {
        $subcategories =  SubCategory::with('category', 'sub_subcategories')->where(['category_id' => $id, 'status' =>1])->get();
        $data['meta_title'] = 'Movie & Web Website';
        $data['meta_keywords'] = 'Movie, Web Series, Video' ;
        $data['meta_description'] = 'Movie Show and Download website';
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        return view('frontend.subcategories', compact('subcategories'), $data);
    }

    public function sub_subcategory($id, $slug)
    {
        $sub_subcategories = SubSubCategory::with('subcategory')->where('subcategory_id', $id)->where('status',1)->get();
        return view('frontend.sub_subcategories', compact('sub_subcategories'));
    }

    public function videos_category($category_id,$slug)
    {
        $movies = Movie::with('favorites', 'comment_count')->where(['category_id' => $category_id, 'video_status' => 'Complete', 'active_status' => 1])->latest()->get();

        $data['meta_title'] = 'Movie & Web Website';
        $data['meta_keywords'] = 'Movie, Web Series, Video' ;
        $data['meta_description'] = 'Movie Show and Download website';
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        $category = Category::findOrFail($category_id);
        return view('frontend.video.category_wise', compact('movies', 'category'), $data);
    }

    public function videos_subcategory($subcategory_id, $slug)
    {

        $movies = Movie::with('favorites', 'comment_count')->where(['subcategory_id' => $subcategory_id, 'video_status' => 'Complete', 'active_status' => 1])->latest()->get();
        $subcategory = SubCategory::with('category')->findOrFail($subcategory_id);
        $data['meta_title'] = 'Movie & Web Website';
        $data['meta_keywords'] = 'Movie, Web Series, Video' ;
        $data['meta_description'] = 'Movie Show and Download website';
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        return view('frontend.video.subcategory_wise', compact('movies', 'subcategory'), $data);
    }

    public function videos_sub_subcategory($sub_subcategory_id, $slug)
    {
        $movies = Movie::with('favorites', 'comment_count')->where(['sub_subcategory_id' => $sub_subcategory_id, 'video_status' => 'Complete', 'active_status' => 1])->get();
        $sub_subcategory = SubSubCategory::with('subcategory')->findOrFail($sub_subcategory_id);
        $data['meta_title'] = 'Movie & Web Website';
        $data['meta_keywords'] = 'Movie, Web Series, Video' ;
        $data['meta_description'] = 'Movie Show and Download website';
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        return view('frontend.video.sub_subcategory_wise', compact('movies', 'sub_subcategory'), $data);
    }

    public function video_details($id, $slug)
    {

        $movie = Movie::with('category','subcategory', 'sub_subcategory', 'comments', 'favorites')->where(['id'=>$id, 'video_status' => 'Complete', 'active_status' => 1])->firstOrFail();
        $blogKey = 'blog_'.$movie->id;
        if(!Session::has($blogKey)){
            $movie->increment('view_count');
            Session::put($blogKey, 1);
        }
        $comment_count = Comment::where('movie_id', $movie->id)->count();

        $categories = Category::with('subcategories')->where('status', 1)->get();

        $data['meta_title'] = $movie->title;
        $data['meta_keywords'] = $movie->title;
        $data['meta_description'] = $movie->description;
        $data['url'] =  URL::current();
        $data['og_image'] =  url('backend/upload/video/'.$movie->image);

        $shareButtons = \Share::page(
            URL::current(),
            'Your share text comes here'
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();


        return view('frontend.video.video_details', compact('movie', 'categories', 'comment_count', 'shareButtons'), $data);
    }

    public function cms($slug)
    {
        $shareButtons = \Share::page(
            URL::current(),
            'Your share text comes here'
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        $cms = Cms::where('slug', $slug)->where('status', 1)->firstOrFail();
        $data['meta_title'] = $cms->title;
        $data['meta_keywords'] = $cms->meta_keyword;
        $data['meta_description'] = $cms->meta_description;
        $data['url'] =  URL::current();
        $data['og_image'] =  url('frontend/images/logo.png');
        return view('frontend.cms_page', compact('cms', 'shareButtons'), $data);
    }
}
