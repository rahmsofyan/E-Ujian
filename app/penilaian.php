<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penilaian extends Model
{
    protected $table = 'penilaians';
    protected $fillable = [ 'idPenilaian','idAgenda','nama','porsi'];
}
