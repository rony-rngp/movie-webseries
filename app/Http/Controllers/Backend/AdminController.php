<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('backend.dashboard');
    }

    public function login(Request $request)
    {

        if (Auth::guard('admin')->check()){
            return redirect()->route('admin.dashboard');
        }

        if ($request->isMethod('post')){
            $this->validate($request, [
               'email' => 'required',
               'password' => 'required'
            ]);

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
                $admin = Auth::guard('admin')->user();
                if ($admin->status == 1){
                    return redirect()->route('admin.dashboard');
                }else{
                    Auth::guard('admin')->logout();
                    notify()->error('Your account is not activated yet! you need to contact admin !', 'Error');
                    return redirect()->back();
                }
            }else{
                notify()->error('These credentials do not match our records', 'Error');
                return redirect()->back();
            }

        }else{
            return view('backend.auth.login');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin');
    }

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('backend.auth.view_profile', compact('admin'));
    }

    public function edit_profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('backend.auth.edit_profile', compact('admin'));
    }

    public function update_profile(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required',
           'email' => 'required|email|unique:admins,id, '.$id,
            'image' => 'image|max:5000'
        ]);

        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/admin/'.$image_name);
            Image::make($image)->resize(200,200)->save($upload_path);
            if ($admin->image != '' && file_exists(public_path('backend/upload/admin/'.$admin->image))){
                unlink(public_path('backend/upload/admin/'.$admin->image));
            }
            $admin->image = $image_name;
        }
        $admin->save();

        notify()->success('Profile Successfully Updated', 'Success');
        return redirect()->route('admin.profile.view');
    }
}
