<?php
Route::get('/', function () {
    return view('welcome');
});

Route::resource('books','BookController');

Route::get('/dashboard','DashboardController@index');

Route::resource('jenis','JenisController');
Route::post('jenistable','JenisController@index');
Route::post('notulen/proses','NotulenController@proses');
Route::post('prosestable/{id}','NotulenController@proses');
Route::post('rapat/update_status','RapatController@update_status');
Route::resource('rapat','RapatController');
Route::post('rapattable','RapatController@index');
Route::get('/tempat/data','TempatController@data_tempat');
Route::resource('tempat','TempatController');
Route::post('peserta/kehadiran','PesertaController@proses_kehadiran');
Route::resource('peserta','PesertaController');
Route::post('peserta/tambah','PesertaController@index');
Route::post('pesertatable/{id}','PesertaController@index');
Route::resource('proses','NotulenController');
Route::post('notulentable','NotulenController@index');
