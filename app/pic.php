<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pic extends Model
{
    //
        protected $table = 'pic';
        protected $primaryKey = 'idPIC';
        public $incrementing = false;
        protected $fillable = [ 'idPIC','namaPIC','keterangan','idUser'];

}
