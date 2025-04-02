@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Đăng ký tài khoản</h2>

        @if (session('register_error'))
            <div>{{ session('register_error') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')
                <small>{{ $message }}</small>
            @enderror

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <small>{{ $message }}</small>
            @enderror

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <small>{{ $message }}</small>
            @enderror

            <label for="password_confirmation">Nhập lại Mật khẩu:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')
                <small>{{ $message }}</small>
            @enderror

            <div class="button-container">
                <p><a href="{{ route('login') }}">Đã có tài khoản</a></p>
                <button type="submit">Đăng ký</button>
            </div>
        </form>
    </div>
@endsection
