<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\AbsensiController;

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

Route::post('login',[LoginController::class,'API_login']);
Route::post('changepass',[LoginController::class,'ChangePassword']);
Route::post('getsiswainfo',[SiswaController::class,'FindSiswa']);
Route::post('getjadwal',[JadwalPelajaranController::class,'getJadwalJson']);
Route::post('checkbarcode',[AbsensiController::class,'CheckBarcodeAbsensi']);
Route::post('readreviewabsen',[AbsensiController::class,'ShowDataAbsensi']);
Route::post('insertabsen',[AbsensiController::class,'insertAbsensi']);
Route::post('dashboardabsen',[AbsensiController::class,'ShowReviewAbsensi']);