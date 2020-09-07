<?php
Auth::routes();
Route::get('nextlogin','Auth\LoginController@authenticate');
Route::get('/','HomeController@index');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

//Start Pegawai Route
Route::post('loginPegawai','PegawaiController@login');
Route::get('keluar','PegawaiController@logout');
Route::get('jsonuser','PegawaiController@userjson');
//End Pegawai Route

//Route::resource('books','BookController');

//Start Hukum Route
Route::resource('produkhukum','HukumController');
Route::post('hukumtable','HukumController@index');
//End Hukum Route

//Start Kelhukum Route
Route::resource('kelhukum','KelhukumController');
Route::post('kelhukumtable','KelhukumController@index');
//End Kelhukum Route

//Start Kathukum Route
Route::resource('kathukum','KathukumController');
Route::post('kathukumtable','KathukumController@index');
Route::get('getkategori/{id}','KathukumController@getkategori');
//End Kathukum Route

//Start Jenis Route
Route::resource('jenis','JenisController');
Route::post('jenistable','JenisController@index');
//End Jenis Route

//Start Anggotadprd Route
Route::resource('anggotadprd','AnggotadprdController');
Route::post('anggotadprdtable','AnggotadprdController@index');
Route::get('anggotadprdSearch','AnggotadprdController@browse');
Route::get('getanggotadprd/{id}','AnggotadprdController@get_user');
Route::get('get_pimpinan/{id}','AnggotadprdController@get_pimpinan');
Route::get('get_sekretaris/{id}','AnggotadprdController@get_sekretaris');
//End Anggotadprd Route

//Start Notulen Route
Route::get('notulen/detail/{id}','NotulenController@proses');
Route::post('prosestable/{id}','NotulenController@proses');
Route::resource('proses','NotulenController');
Route::get('selesai','NotulenController@index1');
Route::get('batal','NotulenController@index2');
Route::get('printnotulen/{id}','NotulenController@print');
Route::get('speech','NotulenController@speech');
Route::get('pegawaiSearch','NotulenController@browse');
//end Notulen Route

//Start Rapat Route
Route::post('rapat/update_status','RapatController@update_status');
Route::resource('rapat','RapatController');
Route::post('rapattable','RapatController@index');
//End Rapat Route

//Start Tempat Route
Route::get('/tempat/data','TempatController@data_tempat');
Route::resource('tempat','TempatController');
//End Tempat Route

//Start Peserta Route
Route::post('peserta/kehadiran','PesertaController@proses_kehadiran');
Route::resource('peserta','PesertaController');
Route::post('peserta/tambah','PesertaController@index');
Route::post('pesertatable/{id}','PesertaController@index');
Route::get('getUser/{id}','PesertaController@get_user');
//End Peserta Route


Route::get('download/{id}',function($id){
	$id=decrypt($id);
	return redirect(url('file/'.$id)); 
});

Route::get('kategori/{id}','HomeController@index');


