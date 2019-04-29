<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    //
   protected $table = 'log';
   protected $fillable = ['fk_idUser','fk_idAgenda','status','lattitudeHP','longitudeHP','namaFileFOTO'];
}
