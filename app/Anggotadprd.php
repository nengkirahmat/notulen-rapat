<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggotadprd extends Model
{
    protected $table="anggotadprd";
    protected $primaryKey="id_anggotadprd";
    protected $fillable = [
        'nama_anggotadprd',
        'jabatan_anggotadprd',
    ];

    use SoftDeletes;
}
