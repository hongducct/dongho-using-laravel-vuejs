<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function index()
    {
        $userStatuses = UserStatus::all();
        return response()->json($userStatuses);
    }
}
