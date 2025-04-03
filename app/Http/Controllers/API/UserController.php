<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function isAuth($authUser,$id): bool
    {
        return $authUser->role == "admin" || $authUser->id == $id;
    }

    public function index(): JsonResponse
    {
        $users = User::paginate(10);
        return $this->sendResponse($users,'fetched users successfully');
    }

    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);
        return $this->sendResponse($user,'fetched users successfully');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $authUser=$request->user();
        if (!$this->isAuth($authUser,$id)) {
            return $this->sendError(['Unauthorised' => 'Bạn không thể chỉnh sửa người dùng này.'], 403);
        }
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|max:8',
            'email' => 'required|email|unique:users,email,' . $id,
            'description' => 'nullable|string',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

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

        // return $this->sendResponse($user, 'Updated successfully');
        return $this->sendResponse($user, $authUser);

    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $authUser=$request->user();
        if (!$this->isAuth($authUser,$id)) {
            return $this->sendError(['Unauthorised' => 'Bạn không thể xóa người dùng này.'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Xóa thành công.']);
    }
}
