<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Absen;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [Absen::class, 'home']);
Route::post('/submit', [Absen::class, 'submit']);
Route::get('/cek', [Absen::class, 'cek']);
Route::get('/info', [Absen::class, 'info']);


Route::get('/login', [Admin::class, 'login']);
Route::post('/auth-login', [Admin::class, 'auth']);
Route::get('/beranda', [Admin::class, 'beranda']);
Route::get('/karyawan', [Admin::class, 'karyawan']);
Route::post('/tambah-karyawan', [Admin::class, 'tambah_karyawan']);
Route::post('/update-karyawan', [Admin::class, 'update_karyawan']);
Route::post('/hapus-karyawan', [Admin::class, 'hapus_karyawan']);
Route::get('/karyawan/{id}', [Admin::class, 'karyawan']);

Route::get('/unit', [Admin::class, 'unit']);
Route::post('/unit/tambah_unit', [Admin::class, 'tambah_unit']);
Route::post('/unit/edit_unit', [Admin::class, 'update_unit']);
Route::post('/unit/hapus_unit', [Admin::class, 'hapus_unit']);
Route::post('/unit/tambah_amanah', [Admin::class, 'tambah_amanah']);
Route::post('/unit/hapus_amanah', [Admin::class, 'hapus_amanah']);


Route::get('/list_absen', [Admin::class, 'list_absen']);
Route::post('/cari-nama', [Admin::class, 'cari_nama']);
Route::post('/cari-unit', [Admin::class, 'cari_unit']);
Route::post('/cari-bulan', [Admin::class, 'cari_bulan']);
Route::post('/cari-tanggal', [Admin::class, 'cari_tanggal']);
// Route::get('admin/cari-nama', [Admin::class, 'cari_nama']);