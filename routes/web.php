<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Absen;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Login;
use App\Http\Controllers\Manager;
use App\Http\Controllers\Supervisor;
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
Route::group(['middleware' => ['web']], function () {
    // your routes here
});
Route::get('/', [Absen::class, 'home']);
Route::post('/submit', [Absen::class, 'submit']);
Route::get('/cek', [Absen::class, 'cek']);
Route::get('/info', [Absen::class, 'info']);
Route::post('/get_status', [Absen::class, 'get_status']);


Route::get('/login', [Login::class, 'login']);
Route::post('/auth-login', [Login::class, 'auth']);
Route::get('/logout', function(){
    if(session()->has('user')){
        session()->pull('user');
    }
    return redirect('login');
});
Route::post('/get_detail', [Admin::class, 'get_detail']);
Route::post('/export-unit', [Admin::class, 'export_unit']);
Route::post('/export-nama', [Admin::class, 'export_nama']);
Route::post('/export-tanggal', [Admin::class, 'export_tanggal']);


Route::middleware(['admin_md'])->group(function () {
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
    Route::post('/unit/daftarkan', [Admin::class, 'daftarkan_unit']);
    Route::post('/unit/hapusdaftar', [Admin::class, 'hapusdaftarkan_unit']);
    Route::post('/unit/tambah_amanah', [Admin::class, 'tambah_amanah']);
    Route::post('/unit/hapus_amanah', [Admin::class, 'hapus_amanah']);

    Route::get('/komponen',[Admin::class, 'komponen']);

    Route::get('/laporan-pendapatan', [Admin::class, 'laporan_pendapatan']);
    Route::post('/buat-pendapatan', [Admin::class, 'buat_pendapatan']);

    Route::get('/list_absen', [Admin::class, 'list_absen']);
    Route::post('/cari-nama', [Admin::class, 'cari_nama']);
    
    Route::post('/cari-unit', [Admin::class, 'cari_unit']);
    Route::post('/cari-bulan', [Admin::class, 'cari_bulan']);
    Route::post('/cari-tanggal', [Admin::class, 'cari_tanggal']);

    Route::get('/user',[Admin::class, 'user']);
    Route::post('/tambah-user',[Admin::class, 'tambah_user']);

    
// Route::get('admin/cari-nama', [Admin::class, 'cari_nama']);

});

Route::middleware(['manager_md'])->group(function () {
    
    Route::get('/beranda3',[Manager::class, 'beranda']);
    Route::get('/form-konsinyasi',[Manager::class, 'form_konsinyasi']);
    Route::post('/tambah-konsinyasi',[Manager::class, 'tambah_konsinyasi']);
    Route::get('/form-pendapatan',[Manager::class, 'form_pendapatan']);
    Route::post('/tambah-pendapatan',[Manager::class, 'tambah_pendapatan']);
    Route::get('/detail-pendapatan',[Manager::class, 'detail_pendapatan']);
    Route::post('/buat-pendapatan-unit',[Manager::class, 'buat_pendapatan']);
    Route::get('/karyawan-manager',[Manager::class, 'karyawan']);
    Route::post('/karyawan-manager', [Manager::class, 'tambah_karyawan']);
    Route::post('/ubah-karyawan', [Manager::class, 'update_karyawan']);
    Route::post('/del-karyawan', [Manager::class, 'hapus_karyawan']);
    Route::get('/rekap-absen', [Manager::class, 'rekap_absen']);
    Route::post('/cari-nama-staff', [Manager::class, 'cari_nama']);
    Route::post('/cari-bulan-staff', [Manager::class, 'cari_bulan']);
    Route::post('/cari-tanggal-staff', [Manager::class, 'cari_tanggal']);

});
Route::middleware(['supervisor'])->group(function () {
    Route::get('/beranda4',[Supervisor::class, 'beranda']);
    Route::get('/cek-data',[Supervisor::class, 'cek_data']);
    Route::post('/semua-data',[Supervisor::class, 'semua_data']);
    Route::get('/semua-data/{id}',[Supervisor::class, 'semua_data']);
    Route::post('/supervisor/cek-laporan',[Supervisor::class, 'data_per_bulan']);
    Route::post('/supervisor/cari-unit',[Supervisor::class, 'cari_unit']);
    Route::post('/supervisor/karyawan',[Supervisor::class, 'cek_karyawan']);

});
