<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()){
            return redirect()->route('user.dashboard');
        }

        if ($request->isMethod('post')){

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
                $user = Auth::user();
                if ($user->status == 1){
                    return redirect()->route('user.dashboard');
                }else{
                    Auth::logout();
                    notify()->error('Yor account disable. Please contact Admin');
                    return redirect()->back();
                }
            }else{
                notify()->error('Email or Password is wrong!');
                return redirect()->back();
            }
        }

        return view('frontend.auth.login');
    }

    public function register(Request $request)
    {
        if (Auth::check()){
            return redirect()->route('user.dashboard');
        }

        if ($request->isMethod('post')){
            $this->validate($request, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'image' => ['required', 'image', 'max:3000']
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $image = $request->file('image');
            if ($image){
                $name = uniqid();
                $ext = $image->getClientOriginalExtension();
                $image_name = $name.'.'.$ext;
                $upload_path = public_path('backend/upload/users/'.$image_name);
                Image::make($image)->resize(200,200)->save($upload_path);
                $user->image = $image_name;
            }

            $user->save();

            notify()->success('Registration Successful. Please Login Here');
            return redirect()->route('login');

        }

        return view('frontend.auth.register');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('frontend.auth.dashboard', compact('user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('frontend.auth.edit_user', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|max:3000',
        ]);
         $user = Auth::user();
        $user->name = $request->name;
        $image = $request->file('image');
        if ($image){
            $name = uniqid();
            $ext = $image->getClientOriginalExtension();
            $image_name = $name.'.'.$ext;
            $upload_path = public_path('backend/upload/users/'.$image_name);
            Image::make($image)->resize(200,200)->save($upload_path);
            if (file_exists(public_path('backend/upload/users/'.$user->image))){
                unlink(public_path('backend/upload/users/'.$user->image));
            }
            $user->image = $image_name;
        }
        $user->save();

        notify()->success('Profile Updated');
        return redirect()->route('user.dashboard');
    }

    public function change_password()
    {
        return view('frontend.auth.change_password');
    }

    public function check_password(Request $request)
    {
        $current_password = $request->current_password;
        if (Hash::check($current_password, Auth::user()->password)){
            return response()->json([
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function update_password(Request $request)
    {
        $this->validate($request,[
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        if (Hash::check($request->current_password, Auth::user()->password)){
            //check new and old password is matching
            if (!Hash::check($request->password_confirmation, Auth::user()->password)) {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password_confirmation);
                $user->save();

                notify()->success('Password Updated!', 'Success');
                return redirect()->route('user.dashboard');
            }else{
                notify()->error('Sorry ! New password can not be same as old password (:', 'Error');
                return redirect()->back();
            }
        }else{
            notify()->error('Current password is wrong!', 'Error');
            return redirect()->back();
        }
    }
}
