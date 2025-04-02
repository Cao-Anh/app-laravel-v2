@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="login-box">
            <h2>Quên mật khẩu</h2>

            @if (session('status'))
                <div class="success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <small>{{ $message }}</small>
                @enderror

                <div class="button-container">
                    <a href="{{ route('login') }}" class="forgot">Quay lại đăng nhập</a>
                    <button type="submit">Gửi liên kết đặt lại</button>
                </div>
            </form>
        </div>
    </div>
@endsection
