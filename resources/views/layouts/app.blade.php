<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Display Flash Messages -->
    @if (session('error'))
        <script>
            alert(@json(session('error')));
            // console.log(@json(session('error')));
        </script>
    @endif
    @if (session('success'))
        <script>
            alert(@json(session('success')));
            // console.log(@json(session('success')));
        </script>
    @endif
    <header>
        <nav>
            <a href="{{ route('users.index') }}">Trang chủ</a> |
            <form style="display:inline" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="all: unset ;cursor: pointer;display: inline;">Đăng xuất</button>
            </form>
        </nav>
    </header>

    <div class="">
        @yield('content') <!-- This is where child content will be inserted -->
    </div>

    <footer>
        <p>Laravel Training @2025</p>
    </footer>

</body>

</html>
