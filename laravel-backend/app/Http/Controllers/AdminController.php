<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function index()
    {
        return Admin::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:admins',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
            // 'avatar' => 'required',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'name.required' => 'Tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => '<PASSWORD>',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự',
            // 'avatar.required' => 'Ảnh đại diện là bắt buộc',
        ]);

        // Tạo thư mục avatars nếu chưa tồn tại
        $avatarPath = storage_path('app/avatars');
        if (!\File::exists($avatarPath)) {
            \File::makeDirectory($avatarPath, 0755, true);
        }

        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(storage_path('app/avatars'), $avatarName);
        }

        // Create new admin
        $admin = new Admin();
        $admin->username = $validated['username'];
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->password = bcrypt($validated['password']);
        $admin->avatar = 'avatars/' . $avatarName; // Đường dẫn ảnh đại diện
        $admin->save();

        return response()->json([
            'message' => 'Admin created successfully',
            'data' => $admin
        ], 201);
    }
    public function deleteAdmin($id) {
        $admin = Admin::find($id);
        if (is_null($admin)) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully'], 204);
    }

    // login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Tên đăng nhập là bắt buộc',
            'password.required' => 'Mật khẩu là bắt buộc',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin ||!\Hash::check($request->password, $admin->password)) {
            return response()->json([
               'message' => 'Tài khoản hoặc mật khẩu không đúng',
            ], 401);
        }
        $token = $admin->createToken('adminToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'admin' => $admin,
            'token' => $token
        ], 200);
    }
    
    // update
    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);

        // Xử lý ảnh đại diện mới nếu được cung cấp
        if ($request->hasFile('avatar')) {
            // Lưu trữ ảnh đại diện vào thư mục lưu trữ cụ thể
            $avatarPath = $request->file('avatar')->store('avatars');
            $admin->avatar = $avatarPath;
        }

        // Kiểm tra nếu có yêu cầu đổi mật khẩu
        if ($request->filled('oldPassword') && $request->filled('newPassword')) {
            // Kiểm tra mật khẩu cũ
            if (\Hash::check($request->oldPassword, $admin->password)) {
                // Mã hóa mật khẩu mới
                $newPassword = \Hash::make($request->newPassword);
                $admin->password = $newPassword;
            } else {
                // Mật khẩu cũ không chính xác
                return response()->json([
                    'message' => 'Old password is incorrect',
                ], 422);
            }
        }

        if (is_null($admin)) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        // $admin->update($request->all());
        $admin->update($request->except(['oldPassword', 'newPassword']));
        return response()->json([
           'message' => 'Admin updated successfully',
            'data' => $admin
        ], 200);
    }
}
