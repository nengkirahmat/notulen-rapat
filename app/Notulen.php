<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Notulen extends Model
{
    protected $table="notulen";
    protected $primaryKey="id_notulen";
    protected $fillable = [
        'id_rapat',
        'id_user',
        'isi_rapat',
        'status_notulen',
    ];

    use SoftDeletes;
}
