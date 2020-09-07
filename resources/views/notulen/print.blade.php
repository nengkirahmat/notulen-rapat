    <?php 
        // fungsi header dengan mengirimkan word
        header("Content-type: application/vnd-ms-excel");
         
        // membuat nama file ekspor "export-to-excel.xls"
        $judul=$rapat[0]->judul_rapat." ".date('d m Y',strtotime($rapat[0]->tgl_rapat));
        $judul=str_replace(" ", "_", $judul).".doc";
        header("Content-Disposition: attachment; filename=$judul");
         
    ?>
<!DOCTYPE html>
<html>
<head>
	<title>NOTULEN RAPAT</title>
<style>
	table{
		font-size: 12px;
	}
</style>
</head>
<body>

	<div style="width: 96%; margin: auto; padding: 10px;">
<h3 style="text-align: center; margin: 5px;"><b>NOTULEN</b></h3>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
	<tr>
		<td width="120px;">Rapat</td>
		<td width="6" align="center">:</td>
		<td>{{$rapat[0]->judul_rapat}}</td>
	</tr>
	<tr>
		<td>Hari/Tanggal<br>Pukul</td>
		<td align="center">:</td>
		<td>
		<?php
		$akhir="";
                if ($rapat[0]->jam_akhir=="00:00"){
                    $akhir="Selesai";
                }else{
                    $akhir=$rapat[0]->jam_akhir;
                }
                $jam=$rapat[0]->jam_mulai." s/d ".$akhir;
		?>
			{{$rapat[0]->hari." / ".date('d F Y',strtotime($rapat[0]->tgl_rapat))}}
			<br>
			{{$jam}}
		</td>
	</tr>
	<tr>
		<td>Pimpinan Rapat</td>
		<td align="center">:</td>
		<td>{{$rapat[0]->pimpinan_rapat}}</td>
	</tr>
	<tr>
		<td>Tempat</td>
		<td align="center">:</td>
		<td>{{$rapat[0]->nama_tempat}}</td>
	</tr>
	<tr>
		<td valign="top">Peserta Rapat</td>
		<td align="center">:</td>
		<td>
			@foreach($peserta as $p)
				{{$p->nama_peserta}}<br>
			@endforeach
		</td>
	</tr>
	<tr>
		<td valign="top">Pembahasan</td>
		<td align="center">:</td>
		<td>
			<?php
			echo $rapat[0]->isi_rapat;
			?>				
		</td>
	</tr>
	<tr>
		<td valign="top">Kesimpulan</td>
		<td align="center">:</td>
		<td>
			<?php
			echo $rapat[0]->kesimpulan;
			?>
		</td>
	</tr>
	<tr>
		<td>Rapat Selesai</td>
		<td align="center">:</td>
		<td>
			{{$rapat[0]->jam_akhir}}
		</td>
	</tr>
</table>
<br><br>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td width="50%" align="center">
			SEKRETARIS<br>
			{{strtoupper($rapat[0]->jabatan_sekretaris)}}
			<br><br><br><br><br>
			{{$rapat[0]->sekretaris}}
		</td>
		<td align="center">
			NOTULEN<br>
			{{strtoupper($rapat[0]->jabatan)}}
			<br><br><br><br><br>
			{{$rapat[0]->nama_lengkap}}
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<br><br>
			PIMPINAN<br>
			{{strtoupper($rapat[0]->jabatan_pimpinan_rapat)}}
			<br><br><br><br><br>
			{{$rapat[0]->pimpinan_rapat}}
		</td>
	</tr>
</table>
</div>

<script>
	window.print();
</script>
</body>
</html>

