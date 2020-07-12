<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    protected $table="tempat";
    protected $primaryKey="id_tempat";
    protected $fillable = [
        'nama_tempat',
        'status_tempat',
    ];

    
}
