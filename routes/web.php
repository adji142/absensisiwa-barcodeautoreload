<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JamPelajaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\AbsensiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class,'login'])->name('login');
Route::post('/action-login', [LoginController::class, 'action_login'])->name('action-login');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Ruangan
|--------------------------------------------------------------------------
|
*/
Route::get('/ruangan', [RuanganController::class,'View'])->name('ruangan')->middleware('auth');
Route::get('/ruangan/form/{id}', [RuanganController::class,'Form'])->name('ruangan-form')->middleware('auth');
Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('ruangan-store')->middleware('auth');
Route::post('/ruangan/edit', [RuanganController::class, 'edit'])->name('ruangan-edit')->middleware('auth');
Route::delete('/ruangan/delete/{id}', [RuanganController::class, 'delete'])->name('ruangan-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Mata Pelajaran
|--------------------------------------------------------------------------
|
*/
Route::get('/matapelajaran', [MataPelajaranController::class,'View'])->name('matapelajaran')->middleware('auth');
Route::get('/matapelajaran/form/{id}', [MataPelajaranController::class,'Form'])->name('matapelajaran-form')->middleware('auth');
Route::post('/matapelajaran/store', [MataPelajaranController::class, 'store'])->name('matapelajaran-store')->middleware('auth');
Route::post('/matapelajaran/edit', [MataPelajaranController::class, 'edit'])->name('matapelajaran-edit')->middleware('auth');
Route::delete('/matapelajaran/delete/{id}', [MataPelajaranController::class, 'delete'])->name('matapelajaran-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Jam Pelajaran
|--------------------------------------------------------------------------
|
*/
Route::get('/jampelajaran', [JamPelajaranController::class,'View'])->name('jampelajaran')->middleware('auth');
Route::post('/jampelajaran-Json', [JamPelajaranController::class,'ViewJson'])->name('jampelajaran-Json')->middleware('auth');
Route::get('/jampelajaran/form/{id}', [JamPelajaranController::class,'Form'])->name('jampelajaran-form')->middleware('auth');
Route::post('/jampelajaran/store', [JamPelajaranController::class, 'store'])->name('jampelajaran-store')->middleware('auth');
Route::post('/jampelajaran/edit', [JamPelajaranController::class, 'edit'])->name('jampelajaran-edit')->middleware('auth');
Route::delete('/jampelajaran/delete/{id}', [JamPelajaranController::class, 'delete'])->name('jampelajaran-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Tahun Ajaran
|--------------------------------------------------------------------------
|
*/
Route::get('/tahunajaran', [TahunAjaranController::class,'View'])->name('tahunajaran')->middleware('auth');
Route::get('/tahunajaran/form/{id}', [TahunAjaranController::class,'Form'])->name('tahunajaran-form')->middleware('auth');
Route::post('/tahunajaran/store', [TahunAjaranController::class, 'store'])->name('tahunajaran-store')->middleware('auth');
Route::post('/tahunajaran/edit', [TahunAjaranController::class, 'edit'])->name('tahunajaran-edit')->middleware('auth');
Route::delete('/tahunajaran/delete/{id}', [TahunAjaranController::class, 'delete'])->name('tahunajaran-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Guru
|--------------------------------------------------------------------------
|
*/
Route::get('/guru', [GuruController::class,'View'])->name('guru')->middleware('auth');
Route::get('/guru/form/{id}', [GuruController::class,'Form'])->name('guru-form')->middleware('auth');
Route::post('/guru/store', [GuruController::class, 'store'])->name('guru-store')->middleware('auth');
Route::post('/guru/edit', [GuruController::class, 'edit'])->name('guru-edit')->middleware('auth');
Route::delete('/guru/delete/{id}', [GuruController::class, 'delete'])->name('guru-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| KelompokAkses
|--------------------------------------------------------------------------
|
*/
Route::get('/roles', [RolesController::class,'View'])->name('roles')->middleware('auth');
Route::get('/roles/form/{id}', [RolesController::class,'Form'])->name('roles-form')->middleware('auth');
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles-store')->middleware('auth');
Route::post('/roles/edit', [RolesController::class, 'edit'])->name('roles-edit')->middleware('auth');
Route::delete('/roles/delete/{id}', [RolesController::class, 'deletedata'])->name('roles-delete')->middleware('auth');
Route::get('/roles/export', [RolesController::class,'Export'])->name('roles-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
*/
Route::get('/user', [UserController::class,'View'])->name('user')->middleware('auth');
Route::get('/user/form/{id}', [UserController::class,'Form'])->name('user-form')->middleware('auth');
Route::post('/user/store', [UserController::class, 'store'])->name('user-store')->middleware('auth');
Route::post('/user/edit', [UserController::class, 'edit'])->name('user-edit')->middleware('auth');
Route::delete('/user/delete/{id}', [UserController::class, 'deletedata'])->name('user-delete')->middleware('auth');
Route::get('/user/export', [UserController::class,'Export'])->name('user-export')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Kelas
|--------------------------------------------------------------------------
|
*/
Route::get('/kelas', [KelasController::class,'View'])->name('kelas')->middleware('auth');
Route::get('/kelas/form/{id}', [KelasController::class,'Form'])->name('kelas-form')->middleware('auth');
Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas-store')->middleware('auth');
Route::post('/kelas/edit', [KelasController::class, 'edit'])->name('kelas-edit')->middleware('auth');
Route::delete('/kelas/delete/{id}', [KelasController::class, 'delete'])->name('kelas-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
|
*/
Route::get('/siswa', [SiswaController::class,'View'])->name('siswa')->middleware('auth');
Route::get('/siswa/form/{id}', [SiswaController::class,'Form'])->name('siswa-form')->middleware('auth');
Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa-store')->middleware('auth');
Route::post('/siswa/edit', [SiswaController::class, 'edit'])->name('siswa-edit')->middleware('auth');
Route::delete('/siswa/delete/{id}', [SiswaController::class, 'delete'])->name('siswa-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Jadwal
|--------------------------------------------------------------------------
|
*/
Route::get('/jadwalpelajaran', [JadwalPelajaranController::class,'View'])->name('jadwalpelajaran')->middleware('auth');
Route::get('/jadwalpelajaran/form/{id}', [JadwalPelajaranController::class,'Form'])->name('jadwalpelajaran-form')->middleware('auth');
Route::post('/jadwalpelajaran/store', [JadwalPelajaranController::class, 'store'])->name('jadwalpelajaran-store')->middleware('auth');
Route::post('/jadwalpelajaran/edit', [JadwalPelajaranController::class, 'edit'])->name('jadwalpelajaran-edit')->middleware('auth');
Route::delete('/jadwalpelajaran/delete/{id}', [JadwalPelajaranController::class, 'delete'])->name('jadwalpelajaran-delete')->middleware('auth');
Route::post('/jadwalpelajaran/getJadwalJson', [JadwalPelajaranController::class, 'getJadwalJson'])->name('jadwalpelajaran-getjson')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Absensi
|--------------------------------------------------------------------------
|
*/
Route::get('/absensi', [AbsensiController::class,'View'])->name('absensi')->middleware('auth');
Route::get('/absensi-generate', [AbsensiController::class,'FormGenerate'])->name('absensi-generate')->middleware('auth');
Route::get('/absensi/form/{id}', [AbsensiController::class,'Form'])->name('absensi-form')->middleware('auth');
Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi-store')->middleware('auth');
Route::post('/absensi/edit', [AbsensiController::class, 'edit'])->name('absensi-edit')->middleware('auth');
Route::delete('/absensi/delete/{id}', [AbsensiController::class, 'delete'])->name('absensi-delete')->middleware('auth');
Route::post('/absensi/generatecode', [AbsensiController::class, 'GenerateQR'])->name('absensi-generatecode')->middleware('auth');

Route::get('/generate-qr-code', [AbsensiController::class, 'generateQrCode']);

Route::post('/absensi/deactivebarcode', [AbsensiController::class, 'DeActivebarcode'])->name('absensi-deactivebarcode')->middleware('auth');
Route::post('readreviewabsen',[AbsensiController::class,'ShowDataAbsensi'])->name('absensi-readreviewabsen')->middleware('auth');