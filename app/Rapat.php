<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rapat;
use Illuminate\Database\Eloquent\SoftDeletes;
class Rapat extends Model
{
    protected $table="rapat";
    protected $primaryKey="id_rapat";
    protected $fillable = [
        'id_jenis',
        'id_tempat',
        'judul_rapat',
        'hari',
        'tgl_rapat',
        'jam_mulai',
        'jam_akhir',
        'pimpinan_rapat',
        'jabatan_pimpinan_rapat',
        'sekretaris',
        'jabatan_sekretaris',
        'sifat_rapat',
        'status_rapat',
    ];

    use SoftDeletes;
 
}
