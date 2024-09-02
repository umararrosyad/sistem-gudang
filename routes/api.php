<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JenisMutasiController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\MutasiController;

use App\Http\Middleware\CheckJWTToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//auth
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware(CheckJWTToken::class);
Route::get('me', [AuthController::class, 'me'])->middleware(CheckJWTToken::class);


Route::middleware(CheckJWTToken::class)->group(function () {

    //user
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    //kategori
    Route::get('kategoris', [KategoriController::class, 'index']);
    Route::post('kategoris', [KategoriController::class, 'store']);
    Route::get('kategoris/{id}', [KategoriController::class, 'show']);
    Route::put('kategoris/{id}', [KategoriController::class, 'update']);
    Route::delete('kategoris/{id}', [KategoriController::class, 'destroy']);

    //lokasi
    Route::get('lokasis', [LokasiController::class, 'index']);
    Route::post('lokasis', [LokasiController::class, 'store']);
    Route::get('lokasis/{id}', [LokasiController::class, 'show']);
    Route::put('lokasis/{id}', [LokasiController::class, 'update']);
    Route::delete('lokasis/{id}', [LokasiController::class, 'destroy']);

    //Jenis Mutasi
    Route::get('jenis_mutasis', [JenisMutasiController::class, 'index']);
    Route::post('jenis_mutasis', [JenisMutasiController::class, 'store']);
    Route::get('jenis_mutasis/{id}', [JenisMutasiController::class, 'show']);
    Route::put('jenis_mutasis/{id}', [JenisMutasiController::class, 'update']);
    Route::delete('jenis_mutasis/{id}', [JenisMutasiController::class, 'destroy']);

    //Barang
    Route::get('barangs', [BarangController::class, 'index']);
    Route::post('barangs', [BarangController::class, 'store']);
    Route::get('barangs/{id}', [BarangController::class, 'show']);
    Route::put('barangs/{id}', [BarangController::class, 'update']);
    Route::delete('barangs/{id}', [BarangController::class, 'destroy']);

    //Mutasi
    Route::get('mutasis', [MutasiController::class, 'index']);
    Route::post('mutasis', [MutasiController::class, 'store']);
    Route::get('mutasis/{id}', [MutasiController::class, 'show']);
    Route::put('mutasis/{id}', [MutasiController::class, 'update']);
    Route::delete('mutasis/{id}', [MutasiController::class, 'destroy']);

    //history mutasi user
    Route::get('users/{id}/mutasis', [MutasiController::class, 'mutasiUser']);

    //history mutasi barang
    Route::get('barangs/{id}/mutasis', [MutasiController::class, 'mutasiBarang']);
});
