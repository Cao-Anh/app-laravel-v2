@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="login-box">
            <h2>Đổi mật khẩu</h2>

            @if (session('change_pw_success'))
                <div class="success">{{ session('change_pw_success') }}</div>
            @endif
            @if (session('change_pw_error'))
                <div class="error">{{ session('change_pw_error') }}</div>
            @endif

            <form method="POST" action="{{ route('changePassword') }}">
                @csrf

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <small>{{ $message }}</small>
                @enderror

                <label>Mật khẩu hiện tại:</label>
                <input type="password" name="current_password" required>
                @error('current_password')
                    <small>{{ $message }}</small>
                @enderror

                <label>Mật khẩu mới:</label>
                <input type="password" name="new_password" required>
                @error('new_password')
                    <small>{{ $message }}</small>
                @enderror

                <label>Xác nhận mật khẩu mới:</label>
                <input type="password" name="new_password_confirmation" required>
                @error('new_password_confirmation')
                    <small>{{ $message }}</small>
                @enderror

                <div class="button-container">
                    <a href="{{ route('login') }}" class="forgot">Quay lại đăng nhập</a>
                    <button type="submit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
