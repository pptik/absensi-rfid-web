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
Route::get('/ruang', 'CInformasi@ruang');
Route::get('/scanner', 'CInformasi@scanner');
Route::group(['prefix' => 'user'],function(){
    Route::post('signup','CUser@signup');
    Route::post('signin','CUser@signin_action');
    Route::get('logout','CUser@logout');
});
Route::group(['prefix' => 'instansi'],function(){
    Route::get('getlist','CInstansi@getalllist');
    Route::post('tambah','CInstansi@tambah');
});
Route::group(['prefix' => 'ruang'],function(){
    Route::get('getlist','CRuang@getalllist');
    Route::post('tambah','CRuang@tambah');
    Route::post('byinstansi','CRuang@getlistbyinstansi');
});
Route::group(['prefix' => 'scanner'],function(){
    Route::post('tambah','CScanner@tambah');
    Route::get('getlist','CScanner@getlistkelasscanner');
});
Route::get('absensi/get_listmac', 'CAbsensi@getlistmac');
Route::get('absensi/get_allabsensi', 'CAbsensi@get_allabsensi');
Route::post('absensi/listabsen', 'CAbsensi@listabsen');
Route::post('absensi/get_listmacbystatus', 'CAbsensi@getlistmacbystatus');
Route::post('absensi/getalllistabsenbymac', 'CAbsensi@getalllistabsenbymac');
Route::get('absensi/get_raw', 'CAbsensi@get_raw');