<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Gambar extends Model
{
	protected $table="gambar";
    protected $fillable = [
    	'id_rapat',
        'nama_gambar',

    ];

     use SoftDeletes;
}
