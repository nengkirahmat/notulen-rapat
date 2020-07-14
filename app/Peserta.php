<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
	protected $table="peserta";
   	protected $primaryKey="id_peserta";
   	protected $fillable = [
   		'id_rapat',
   		'nama_peserta',
   		'jabatan',
        'status_hadir',
    ];

    use SoftDeletes;
}
