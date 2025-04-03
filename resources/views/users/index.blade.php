@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách người dùng</h1>
        <table>
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>hinh anh</th>
                    <th>Email</th>
                    <th>Mô tả</th>
                    <th>Lệnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td >
                            <?php if (!empty($user->photo)): ?>
                            <img src="<?= asset($user->photo) ?>" alt="User Image" style="max-width: 150px; height: auto;">
                            <?php else: ?>
                                <p>No image available</p>
                            <?php endif; ?>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->description }}</td>
                        <td>
                            <button class="index-button" style="background-color: green; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="window.location.href='{{ route('users.show', $user->id) }}'">Xem</button>
                            @if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->id == $user->id))
                                <button class="index-button" style="background-color: blue; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="window.location.href='{{ route('users.edit', $user->id) }}'">Sửa</button>
                            @endif
                            @if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->id == $user->id))
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="index-button" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                </form>
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $users->links() }}
    </div>
@endsection
