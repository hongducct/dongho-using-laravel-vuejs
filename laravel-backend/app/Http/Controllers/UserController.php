<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
    }
    public function index()
    {
        $users = User::join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select(
                'users.*',
                'users_status.name as status',
                \DB::raw("CONCAT('" . \URL::to('/') . "/storage/', users.avatar) AS avatar")
            )
            ->paginate();
        return response()->json($users);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'status_id' => 'required|exists:users_status,id',
        ]);

        // Update the user's status
        $user->update($validatedData);

        return response()->json([
            'message' => 'User status updated successfully',
            'data' => $user
        ], 200);
    }

    // Method để tải ảnh lên
    public function uploadAvatar(Request $request)
    {
        // Kiểm tra xem yêu cầu có chứa tệp ảnh không
        if ($request->hasFile('avatar')) {
            // Lưu trữ ảnh đại diện vào thư mục lưu trữ cụ thể
            $path = $request->file('avatar')->store('avatars'); // Đường dẫn thư mục lưu trữ ảnh đại diện, bạn có thể đặt theo ý của mình

            // Trả về đường dẫn ảnh đại diện đã lưu trữ
            return response()->json(['imageUrl' => $path], 200);
        }

        // Trả về lỗi nếu không có tệp ảnh được tải lên
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Xử lý ảnh đại diện mới nếu được cung cấp
        if ($request->hasFile('avatar')) {
            // Lưu trữ ảnh đại diện mới và cập nhật đường dẫn trong cơ sở dữ liệu
            $avatarPath = $request->file('avatar')->store('avatars'); // Đường dẫn thư mục lưu trữ ảnh đại diện, bạn có thể đặt theo ý của mình
            $user->avatar = $avatarPath;
        }
        // Kiểm tra nếu có yêu cầu đổi mật khẩu
        if ($request->filled('oldPassword') && $request->filled('newPassword')) {
            // Kiểm tra mật khẩu cũ
            if (\Hash::check($request->oldPassword, $user->password)) {
                // Mã hóa mật khẩu mới
                $newPassword = \Hash::make($request->newPassword);
                $user->password = $newPassword;
            } else {
                // Mật khẩu cũ không chính xác
                return response()->json([
                    'message' => 'Old password is incorrect',
                ], 422);
            }
        }

        $user->update($request->except(['oldPassword', 'newPassword']));
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }
}
