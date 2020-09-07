<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Pegawai extends Model
{
    protected $table="tbl_user";

    protected $fillable = [
        'id_user', 'nama_lengkap', 'id_opd', 'nama_opd', 'hp','jabatan','level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    // use SoftDeletes;
}
