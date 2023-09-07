<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function show()
    {
        $cms = Cms::all();
        return view('backend.cms.view', compact('cms'));
    }

    public function add()
    {
        return view('backend.cms.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:cms',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ]);


        $cms = new Cms();
        $cms->title = $request->title;
        $cms->slug = Str::slug($request->title);
        $cms->description = $request->description;
        $cms->meta_description = $request->meta_description;
        $cms->meta_keyword = $request->meta_keyword;
        $cms->status = 0;
        $cms->save();

        notify()->success('Cms Added', 'Success');
        return redirect()->route('admin.cms.view');
    }

    public function edit($id)
    {
        $cms = Cms::findOrFail($id);
        return view('backend.cms.edit', compact('cms'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:cms',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ]);

        $cms = Cms::findOrFail($id);
        $cms->title = $request->title;
        $cms->slug = Str::slug($request->title);
        $cms->description = $request->description;
        $cms->meta_description = $request->meta_description;
        $cms->meta_keyword = $request->meta_keyword;
        $cms->save();

        notify()->success('Cms Updated', 'Success');
        return redirect()->route('admin.cms.view');
    }

    public function destroy($id)
    {
        $cms = Cms::findOrFail($id);
        $cms->delete();
        notify()->success('Cms Deleted', 'Success');
        return redirect()->route('admin.cms.view');
    }

    public function status(Request $request)
    {
        $cms = Cms::findOrFail($request->id);
        $cms->status = $request->status;
        $cms->save();
        return response()->json(['success' => 'success']);
    }
}
