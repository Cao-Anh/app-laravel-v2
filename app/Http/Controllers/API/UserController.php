<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function isAuth($id): bool
    {
        return Auth::user()->role == "admin" || Auth::user()->id == $id;
    }

    public function index(): JsonResponse
    {
        $users = User::paginate(10);
        return response()->json(['users' => $users]);
    }

    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function edit($id): JsonResponse
    {
        if (!$this->isAuth($id)) {
            return response()->json(['error' => 'Bạn không thể chỉnh sửa người dùng này.'], 403);
        }

        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'username' => 'required|string|min:3|max:8',
            'email' => 'required|email|unique:users,email,' . $id,
            'description' => 'nullable|string',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $imageName);
            $photoUrl = 'images/' . $imageName;
            $user->photo = $photoUrl;
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Cập nhật thành công.', 'user' => $user]);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        if (!$this->isAuth($id)) {
            return response()->json(['error' => 'Bạn không thể xóa người dùng này.'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Xóa thành công.']);
    }
}
