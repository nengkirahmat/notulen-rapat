<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    protected $table="jenis";
    protected $primaryKey="id_jenis";
    protected $fillable = [
        'nama_jenis',
        'status_jenis',
    ];

    use SoftDeletes;
}
