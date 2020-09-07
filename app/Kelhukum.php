<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Kelhukum extends Model
{
       protected $table="kelhukum";
    protected $primaryKey="id_kel";
    protected $fillable = [
        'nama_kel',
    ];
 use SoftDeletes;
}
