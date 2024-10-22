<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Kiểm tra trạng thái người dùng
            if ($user->status_id == 1) {
                $token = $user->createToken('myapp')->plainTextToken;
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    // 'message' => 'Your account is temporarily locked'
                    'message' => "Tài khoản của bạn bị tạm khóa,\n vui lòng liên hệ qua mail <b>hongducct23@gmail.com</b> để được mở khóa",
                ], 403); // Trạng thái 403 Forbidden
            }
        }
    
        return response()->json([
            'message' => 'Tài khoản hoặc mật khẩu không đúng',
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'avatar' => '',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'name.required' => 'Tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => '<PASSWORD>',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Tạo thư mục avatars nếu chưa tồn tại
        $avatarPath = storage_path('app/public/avatars');
        if (!\File::exists($avatarPath)) {
            \File::makeDirectory($avatarPath, 0755, true);
        }

        // Lưu tệp tin ảnh đại diện nếu có
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move('storage/avatars', $avatarName);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => isset($avatarName) ? 'avatars/' . $avatarName : null, // Đường dẫn ảnh đại diện
            'username' => $request->username,
            'status_id' => 1
        ]);

        $token = $user->createToken('myapp')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
