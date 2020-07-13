<?php
Route::get('/', function () {
    return view('welcome');
});

Route::resource('books','BookController');

Route::get('/dashboard','DashboardController@index');

Route::resource('jenis','JenisController');
Route::post('jenistable','JenisController@index');
Route::resource('rapat','RapatController');
Route::post('rapattable','RapatController@index');
Route::resource('tempat','TempatController');
Route::resource('peserta','PesertaController');
Route::get('peserta/index/{id}','PesertaController@index');
Route::post('pesertatable/{id}','PesertaController@index');
