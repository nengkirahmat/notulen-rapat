@extends("tem.template")

@section("content")
<?php
$data = session()->get('key');
if ($data[0]->level==1){
	$level="Admin";
	$nama=$data[0]->nama_lengkap;
	echo "<h1 style='text-align:center'>Welcome <b>".$nama."</b><br>Kamu Login Sebagai <b>".$level."</b></h1>";
}elseif ($data[0]->level==2){
	$level="Notulen";
	$nama=$data[0]->nama_lengkap;
	echo "<h1 style='text-align:center'>Welcome <b>".$nama."</b><br>Kamu Login Sebagai <b>".$level."</b></h1>";
}elseif ($data[0]->level==3){
	$level="pimpinan";
	$nama=$data[0]->nama_lengkap;
	echo "<h1 style='text-align:center'>Welcome <b>".$nama."</b></h1>";
}
?>
@endsection