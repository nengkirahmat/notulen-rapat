<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Kathukum extends Model
{
           protected $table="kathukum";
    protected $primaryKey="id_kat";
    protected $fillable = [
        'nama_kat',
        'kelompok',
    ];
 use SoftDeletes;
}
