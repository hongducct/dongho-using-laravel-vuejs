<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// UserController
Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/users', [UserController::class, 'index']);
Route::put('/users/{id}/status', [UserController::class, 'updateStatus']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::post('/upload-avatar', [UserController::class, 'uploadAvatar']);

// AdminController
Route::get('/admins', [AdminController::class, 'index']);
Route::post('/admins', [AdminController::class,'store']);
Route::delete('/admins/{id}', [AdminController::class, 'deleteAdmin']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::put('/admin/{id}', [AdminController::class, 'updateAdmin']);

// ProductController
Route::get('/product/{id}', [ProductController::class,'show']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products-category/{id}', [ProductController::class, 'getProductsByCategoryId']);
Route::get('/categories', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::post('/upload-images', [ProductController::class, 'uploadImages']);
Route::put('/product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);
// Route::post('/upload', [ImageController::class,'store']);

// AuthController
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// UserStatusController
Route::get('/userstatus', [UserStatusController::class, 'index']);

// AddressController
Route::post('/address', [AddressController::class,'store']);
Route::get('/address', [AddressController::class, 'index']);
Route::get('/address/{id}', [AddressController::class,'show']);
Route::put('/address/{id}', [AddressController::class, 'update']);
Route::delete('/address/{id}', [AddressController::class, 'destroy']);
// ContactController
Route::post('/contact', [ContactController::class, 'store']);
