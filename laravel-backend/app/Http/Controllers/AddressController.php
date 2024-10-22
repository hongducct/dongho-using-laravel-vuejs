<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Lấy tất cả địa chỉ
    public function index()
    {
        return Address::all();
    }

    // Lấy địa chỉ theo user_id
    public function showByUser($id)
    {
        return Address::where('user_id', $id)->get();
    }
    public function show($id)
    {
        // return Address::find($id);
        return Address::where('user_id', $id)->get();
    }

    // Thêm địa chỉ
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Create a new address using the validated data
        $address = new Address([
            'user_id' => $validatedData['user_id'],
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone_number'],
            'province' => $validatedData['province'],
            'district' => $validatedData['district'],
            'ward' => $validatedData['ward'],
            'address' => $validatedData['address'],
        ]);

        // Save the address to the database
        $address->save();

        // Return a response indicating success
        return response()->json(['message' => 'Address created successfully', 'data' => $address], 201);
    }

    // Cập nhật địa chỉ
    public function update(Request $request, $id)
    {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Find the address using the id
        // Update the address using the validated data
        $address->name = $validatedData['name'];
        $address->phone_number = $validatedData['phone_number'];
        $address->province = $validatedData['province'];
        $address->district = $validatedData['district'];
        $address->ward = $validatedData['ward'];
        $address->address = $validatedData['address'];
        // Save the address to the database
        $address->save();
        // Return a response indicating success
        return response()->json(['message' => 'Address updated successfully', 'data' => $address], 200);

    }

    // Xóa địa chỉ
    public function destroy($id)
    {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }
        $address->delete();
        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
