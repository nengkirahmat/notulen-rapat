<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Hukum extends Model
{
    protected $table='hukum';
    protected $primaryKey="id_hukum";
    protected $fillable = [
        'kelompok',
        'kategori',
        'nama_hukum',
        'tentang',
        'tgl_hukum',
        'status_hukum',
        'file_hukum'
    ];

 use SoftDeletes;
}
