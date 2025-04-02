@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="login-box">
            <h2>Đặt lại mật khẩu</h2>

            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <small>{{ $message }}</small>
                @enderror

                <label>Mật khẩu mới:</label>
                <input type="password" name="password" required>
                @error('password')
                    <small>{{ $message }}</small>
                @enderror

                <label>Xác nhận mật khẩu mới:</label>
                <input type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <small>{{ $message }}</small>
                @enderror

                <div class="button-container">
                    <button type="submit">Đặt lại mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
