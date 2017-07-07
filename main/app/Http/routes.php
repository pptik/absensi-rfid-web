<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'CInformasi@index');
/*Route::get('/', function (){
    cas()->authenticate();
});*/

Route::get('tes', function () {
    return view('tes-map');
});

Route::get('/login', function () {
    return view('loginpage');
});
Route::get('/instansi', 'CInformasi@instansi');
Route::get('/ruang', 'CInformasi@ruang');
Route::get('/scanner', 'CInformasi@scanner');
Route::get('/jadwal', 'CInformasi@jadwal');
Route::get('/absen/jadwal', 'CInformasi@absenbyjadwal');
Route::group(['prefix' => 'user'],function(){
    Route::post('signup','CUser@signup');
    Route::post('signin','CUser@signin_action');
    Route::get('logout','CUser@logout');
});
Route::group(['prefix' => 'instansi'],function(){
    Route::get('getlist','CInstansi@getalllist');
    Route::post('tambah','CInstansi@tambah');
    Route::post('delete','CInstansi@delete');
});
Route::group(['prefix' => 'ruang'],function(){
    Route::get('getlist','CRuang@getalllist');
    Route::post('tambah','CRuang@tambah');
    Route::post('byinstansi','CRuang@getlistbyinstansi');
    Route::post('delete','CRuang@delete');
});
Route::group(['prefix' => 'scanner'],function(){
    Route::post('tambah','CScanner@tambah');
    Route::get('getlist','CScanner@getlistkelasscanner');
    Route::post('remove','CScanner@removeScanner');
});
Route::group(['prefix' => 'jadwal'],function(){
    Route::post('tambah','CJadwal@tambah');
    Route::post('delete','CJadwal@deletejadwal');
    Route::get('listall','CJadwal@getlistjadwal');
    Route::post('test','CJadwal@getlistabsenbyjadwal');
});
Route::get('absensi/get_listmac', 'CAbsensi@getlistmac');
Route::get('absensi/get_allabsensi', 'CAbsensi@get_allabsensi');
Route::post('absensi/listabsen', 'CAbsensi@listabsen');
Route::post('absensi/get_listmacbystatus', 'CAbsensi@getlistmacbystatus');
Route::post('absensi/getalllistabsenbymac', 'CAbsensi@getalllistabsenbymac');
Route::get('absensi/get_raw', 'CAbsensi@get_raw');