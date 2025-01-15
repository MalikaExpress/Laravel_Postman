<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('categories')->group(function () {
    // Menambahkan kategori baru
    Route::post('create_Cat', [CategoryController::class, 'create_Cat']); 
    
    // Mendapatkan semua kategori
    Route::get('getAll_Cat', [CategoryController::class, 'getAll_Cat']); 
    
    // Mendapatkan detail kategori berdasarkan ID
    Route::get('get_Cat/{id}', [CategoryController::class, 'get_Cat']); 
    
    // Mengupdate data kategori berdasarkan ID
    Route::put('update_Cat/{id}', [CategoryController::class, 'update_Cat']); 
    
    // Menghapus kategori berdasarkan ID
    Route::delete('delete_Cat/{id}', [CategoryController::class, 'delete_Cat']); 
});


Route::prefix('movies')->group(function () {
    // Menambahkan film baru
    Route::post('create_Mov', [MovieController::class, 'create_Mov']); 
    
    // Mendapatkan semua film
    Route::get('getAll_Mov', [MovieController::class, 'getAll_Mov']); 
    
    // Mendapatkan detail film berdasarkan ID
    Route::get('get_Mov/{id}', [MovieController::class, 'get_Mov']); 
    
    // Mengupdate data film berdasarkan ID
    Route::put('update_Mov/{id}', [MovieController::class, 'update_Mov']); 
    
    // Menghapus film berdasarkan ID
    Route::delete('delete_Mov/{id}', [MovieController::class, 'delete_Mov']); 
});

Route::delete("/hapus_user/{id}",[AuthController::class,"hapus_user"]);

Route::put("/update_user/{id}",[AuthController::class,"update_user"]);

Route::get("/get_detail_user/{id}",[AuthController::class,"getDetailUser"]);

Route::get("/get_user",[AuthController::class,"getUser"]);

Route::post('register_admin', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
