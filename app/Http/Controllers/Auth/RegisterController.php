<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:8',
            'email' => 'required|email',
            'password' => 'required|string|min:5|max:9|regex:/[A-Z]/|confirmed',
        ]);
        if(User::where('username',$request->username)->exists()){
            return back()->with('register_error','Tên người dùng này đã được đăng kí.');
        }
        if(User::where('email',$request->email)->exists()){
            return back()->with('register_error','Email này đã được đăng kí.');
        }
        $user=User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('users.index')->with('success','Tạo tài khoản thành công.');
             
    }
}
