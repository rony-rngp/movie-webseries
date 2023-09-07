<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function show()
    {
        $categories = Category::latest()->get();
        return view('backend.category.view', compact('categories'));
    }

    public function add()
    {
        return view('backend.category.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|unique:categories',
           'image' => 'required|image|max:5000'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = make_slug($request->name);
        $category->status = 1;
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            //---Main Image
            $upload_path = public_path('backend/upload/category/'.$image_name);
            Image::make($image)->resize(500,333)->save($upload_path);

            //-----Slider Image
            $upload_path = public_path('backend/upload/category/slider/'.$image_name);
            Image::make($image)->resize(1600,400)->save($upload_path);
            $category->image = $image_name;
        }
        $category->save();

        notify()->success('Category Added', 'Success');
        return redirect()->route('admin.category.view');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$id,
            'image' => 'image|max:5000'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = make_slug($request->name);
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;

            //-----Main Image
            $upload_path = public_path('backend/upload/category/'.$image_name);
            Image::make($image)->resize(500,333)->save($upload_path);
            if (file_exists(public_path('backend/upload/category/'.$category->image))){
                unlink(public_path('backend/upload/category/'.$category->image));
            }
            //-----Slider Image
            $upload_path = public_path('backend/upload/category/slider/'.$image_name);
            Image::make($image)->resize(1600,400)->save($upload_path);
            if (file_exists(public_path('backend/upload/category/slider/'.$category->image))){
                unlink(public_path('backend/upload/category/slider/'.$category->image));
            }

            $category->image = $image_name;
        }
        $category->save();

        notify()->success('Category Updated', 'Success');
        return redirect()->route('admin.category.view');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if (file_exists(public_path('backend/upload/category/'.$category->image))){
            unlink(public_path('backend/upload/category/'.$category->image));
        }

        if (file_exists(public_path('backend/upload/category/slider/'.$category->image))){
            unlink(public_path('backend/upload/category/slider/'.$category->image));
        }
        $category->delete();

        notify()->success('Category Deleted', 'Success');
        return redirect()->back();
    }

    public function status(Request $request)
    {
        $category = Category::findorFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['messege' => 'success']);
    }
}
