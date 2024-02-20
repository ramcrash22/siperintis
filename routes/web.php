<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest:karyawan'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    /*Penulisan Route untuk Laravel 9 ketas */
    Route::post('/proseslogin', 'App\Http\Controllers\AuthController@proseslogin');
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', 'App\Http\Controllers\AuthController@prosesloginadmin');
});

Route::middleware(['auth:karyawan'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', 'App\Http\Controllers\AuthController@proseslogout');

    //presensi
    Route::get('/presensi/create', 'App\Http\Controllers\PresensiController@create');
    Route::post('/presensi/store', 'App\Http\Controllers\PresensiController@store');

    //edit profile
    Route::get('/editprofile', 'App\Http\Controllers\PresensiController@editprofile');
    Route::post('/presensi/{nik}/updateprofile', 'App\Http\Controllers\PresensiController@updateprofile');

    //ganti password
    Route::get('/gantipassword', 'App\Http\Controllers\PresensiController@gantipassword');
    Route::post('/presensi/{nik}/updatepassword', 'App\Http\Controllers\PresensiController@updatepassword');

    //histori
    Route::get('/presensi/histori', 'App\Http\Controllers\PresensiController@histori');
    Route::post('/gethistori', 'App\Http\Controllers\PresensiController@gethistori');

    //izin
    Route::get('/presensi/izin', 'App\Http\Controllers\PresensiController@izin');
    Route::get('/presensi/pengajuanizin', 'App\Http\Controllers\PresensiController@pengajuanizin');
    Route::post('/presensi/storeizin', 'App\Http\Controllers\PresensiController@storeizin');
    Route::post('/presensi/cekpengajuanizin', 'App\Http\Controllers\PresensiController@cekpengajuanizin');

    //cuti
    Route::get('/presensi/cuti', 'App\Http\Controllers\PresensiController@cuti');

    //lokasi
    Route::get('/presensi/lokasi', 'App\Http\Controllers\PresensiController@lokasi');

    //lembur
    Route::get('/presensi/lembur', 'App\Http\Controllers\PresensiController@lembur');

});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', 'App\Http\Controllers\AuthController@proseslogoutadmin');
    Route::get('/panel/dashboardadmin', 'App\Http\Controllers\DashboardController@dashboardadmin');

    //karyawan
    Route::get('/karyawan', 'App\Http\Controllers\KaryawanController@index');
    Route::post('/karyawan/store', 'App\Http\Controllers\KaryawanController@store');
    Route::post('/karyawan/edit', 'App\Http\Controllers\KaryawanController@edit');
    Route::post('/karyawan/{nik}/update', 'App\Http\Controllers\KaryawanController@update');
    Route::post('/karyawan/{nik}/delete', 'App\Http\Controllers\KaryawanController@delete');

    //wilker
    Route::get('/wilker', 'App\Http\Controllers\WilkerController@index');
    Route::post('/wilker/store', 'App\Http\Controllers\WilkerController@store');
    Route::post('/wilker/edit', 'App\Http\Controllers\WilkerController@edit');
    Route::post('/wilker/{kodewilker}/update', 'App\Http\Controllers\WilkerController@update');
    Route::post('/wilker/{kodewilker}/delete', 'App\Http\Controllers\WilkerController@delete');

    //presensi monitoring
    Route::get('/presensi/monitoring', 'App\Http\Controllers\PresensiController@monitoring');
    Route::post('/getpresensi', 'App\Http\Controllers\PresensiController@getpresensi');
    Route::post('/showmap', 'App\Http\Controllers\PresensiController@showmap');
    Route::get('/presensi/laporan', 'App\Http\Controllers\PresensiController@laporan');
    Route::post('/presensi/showlaporan', 'App\Http\Controllers\PresensiController@cetaklaporan');
    Route::get('/presensi/rekap', 'App\Http\Controllers\PresensiController@rekap');
    Route::post('/presensi/showrekap', 'App\Http\Controllers\PresensiController@cetakrekap');
    Route::get('/presensi/sakitizin', 'App\Http\Controllers\PresensiController@sakitizin');
    Route::post('/presensi/approvesakitizin', 'App\Http\Controllers\PresensiController@approvesakitizin');
    Route::get('/presensi/{id}/batalkansakitizin', 'App\Http\Controllers\PresensiController@batalkansakitizin');

    //konfigurasi
    Route::get('/konfigurasi/lokasikantor', 'App\Http\Controllers\KonfigurasiController@lokasikantor');
    Route::post('/konfigurasi/updatelokasikantor', 'App\Http\Controllers\KonfigurasiController@updatelokasikantor');

    //konfigurasi jam kerja
    Route::get('/konfigurasi/jamkerja', 'App\Http\Controllers\KonfigurasiController@jamkerja');
    Route::post('/konfigurasi/jamkerjastore', 'App\Http\Controllers\KonfigurasiController@jamkerjastore');
    Route::post('/konfigurasi/editjamkerja', 'App\Http\Controllers\KonfigurasiController@editjamkerja');
    Route::post('/konfigurasi/{kode_jam_kerja}/updatejamkerja', 'App\Http\Controllers\KonfigurasiController@updatejamkerja');
    Route::post('/konfigurasi/{kode_jam_kerja}/deletejamkerja', 'App\Http\Controllers\KonfigurasiController@deletejamkerja');
    Route::get('/konfigurasi/{nik}/setjamkerja', 'App\Http\Controllers\KonfigurasiController@setjamkerja');
    Route::post('/konfigurasi/storesetjamkerja', 'App\Http\Controllers\KonfigurasiController@storesetjamkerja');
    Route::post('/konfigurasi/updatesetjamkerja', 'App\Http\Controllers\KonfigurasiController@updatesetjamkerja');
});


