<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($credentials, $request->remember)) {
            session()->regenerate();
            return redirect()->route('users.index')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('login_error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Đã đăng xuất thành công.');
    }
}
