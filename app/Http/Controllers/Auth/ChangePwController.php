<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ChangePwController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.changePassword');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'current_password', 'new_password', 'new_password_confirmation']), [
            'email' => 'required|email|exists:users,email',
            'current_password' => 'required|string|min:5|max:9|regex:/[A-Z]/',
            'new_password' => 'required|string|min:5|max:9|regex:/[A-Z]/|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('change_pw_error', 'Email hoặc mật khẩu hiện tại không đúng.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('change_pw_success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
