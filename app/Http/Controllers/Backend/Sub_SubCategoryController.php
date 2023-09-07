<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class Sub_SubCategoryController extends Controller
{
    public function show()
    {
        $sub_subcategories = SubSubCategory::with('subcategory')->latest()->get();
        return view('backend.sub_subcategory.view', compact('sub_subcategories'));
    }

    public function add()
    {
        $categories = Category::with('subcategories')->where('status',  1)->get();
        return view('backend.sub_subcategory.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subcategory_id' => 'required',
            'name' => 'required',
        ]);

        $sub_subcategory = new SubSubCategory();
        $sub_subcategory->subcategory_id = $request->subcategory_id;
        $sub_subcategory->name = $request->name;
        $sub_subcategory->slug = make_slug($request->name);
        $sub_subcategory->status = 1;

        $sub_subcategory->save();
        notify()->success('Sub Sub-Category Added', 'Success');
        return redirect()->route('admin.sub_subcategory.view');
    }

    public function edit($id)
    {
        $categories = Category::with('subcategories')->where('status',  1)->get();
        $sub_subcategory = SubSubCategory::with('subcategory')->findOrfail($id);
        return view('backend.sub_subcategory.edit', compact('categories', 'sub_subcategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subcategory_id' => 'required',
            'name' => 'required',
        ]);

        $sub_subcategory = SubSubCategory::findOrFail($id);
        $sub_subcategory->subcategory_id = $request->subcategory_id;
        $sub_subcategory->name = $request->name;
        $sub_subcategory->slug = make_slug($request->name);

        $sub_subcategory->save();
        notify()->success('Sub Sub-Category Updated', 'Success');
        return redirect()->route('admin.sub_subcategory.view');
    }

    public function destroy($id)
    {
        $sub_subcategory = SubSubCategory::findOrFail($id);
        $sub_subcategory->delete();
        notify()->success('Sub Sub-Category Deleted', 'Success');
        return redirect()->back();
    }

    public function status(Request $request)
    {
        $sub_subcategory = SubSubCategory::findorFail($request->id);
        $sub_subcategory->status = $request->status;
        $sub_subcategory->save();
        return response()->json(['messege' => 'success']);
    }
}
