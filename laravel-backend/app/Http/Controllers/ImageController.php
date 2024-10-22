<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'images.*.required' => 'Hình ảnh sản phẩm là bắt buộc',
            'images.*.image' => 'Tệp tin phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có đuôi mở rộng: jpeg, png, jpg, gif',
        ]);
    }
}
