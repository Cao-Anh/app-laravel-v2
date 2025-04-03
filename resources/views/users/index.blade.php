@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách người dùng</h1>
    <table>
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Hình ảnh</th>
                <th>Email</th>
                <th>Mô tả</th>
                <th>Lệnh</th>
            </tr>
        </thead>
        <tbody id="users-list">
            <!-- Dữ liệu sẽ được điền bằng AJAX -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div id="pagination-links"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchUsers('/api/users'); // Gọi API khi trang tải

        function fetchUsers(url) {
            fetch(url, {
                headers: {
                    'Authorization': 'Bearer 3|AclOIfikLLybZ5KkYQePrJLzEQ6w1dUdzuzTI2RMc292b68f' // Thay bằng token thực tế
                }
            })
            .then(response => response.json())
            .then(data => {
                let usersList = document.getElementById("users-list");
                usersList.innerHTML = ""; // Xóa nội dung cũ

                data.data.data.forEach(user => { // data.data chứa mảng người dùng từ API
                    let tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${user.username}</td>
                        <td>
                            ${user.photo ? `<img src="{{ asset('${user.photo}') }}" style="max-width: 150px; height: auto;">` : '<p>No image available</p>'}
                        </td>
                        <td>${user.email}</td>
                        <td>${user.description}</td>
                        <td>
                            <button class="index-button" style="background-color: green; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="window.location.href='/users/${user.id}'">Xem</button>
                            
                            @if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->id == user.id))
                                <button class="index-button" style="background-color: blue; color: white; border: none; padding: 5px 10px; cursor: pointer;" onclick="window.location.href='/users/${user.id}/edit'">Sửa</button>

                                <form action="/users/${user.id}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="index-button" style="background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">Xóa</button>
                                </form>
                            @endif
                        </td>
                    `;
                    usersList.appendChild(tr);
                });

                // Xử lý phân trang
                let paginationLinks = document.getElementById("pagination-links");
                paginationLinks.innerHTML = data.data.links.map(link => 
                    `<a href="#" onclick="fetchUsers('${link.url}')" style="margin: 0 5px;">${link.label}</a>`
                ).join('');
            })
            .catch(error => console.error("Lỗi khi lấy dữ liệu:", error));
        }
    });
</script>
@endsection
