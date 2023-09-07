<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    public function show()
    {
        $subcategories = SubCategory::with('category')->latest()->get();
        return view('backend.subcategory.view', compact('subcategories'));
    }

    public function add()
    {
        $categories = Category::where('status',  1)->get();
        return view('backend.subcategory.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'category_id' => 'required',
            'name' => 'required',
            'image' => 'required|image|max:5000'
        ]);

        $subcategory = new SubCategory();
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = make_slug($request->name);
        $subcategory->status = 1;
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/subcategory/'.$image_name);
            Image::make($image)->resize(200,200)->save($upload_path);
            $subcategory->image = $image_name;
        }
        $subcategory->save();
        notify()->success('Sub Category Added', 'Success');
        return redirect()->route('admin.subcategory.view');
    }

    public function edit($id)
    {
        $subcategory = SubCategory::with('category')->findOrfail($id);
        $categories = Category::where('status',  1)->get();
        return view('backend.subcategory.edit', compact('categories', 'subcategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'image|max:5000'
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = make_slug($request->name);
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/subcategory/'.$image_name);
            Image::make($image)->resize(200,200)->save($upload_path);
            if (file_exists(public_path('backend/upload/subcategory/'.$subcategory->image))){
                unlink(public_path('backend/upload/subcategory/'.$subcategory->image));
            }
            $subcategory->image = $image_name;
        }
        $subcategory->save();
        notify()->success('Sub Category Updated', 'Success');
        return redirect()->route('admin.subcategory.view');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        if (file_exists(public_path('backend/upload/subcategory/'.$subcategory->image))){
            unlink(public_path('backend/upload/subcategory/'.$subcategory->image));
        }
        $subcategory->delete();
        notify()->success('Sub Category Deleted', 'Success');
        return redirect()->back();
    }

    public function status(Request $request)
    {
        $category = SubCategory::findorFail($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['messege' => 'success']);
    }
}
