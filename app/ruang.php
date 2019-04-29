<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ruang extends Model
{
    //
        protected $table = 'ruang';
	protected $primaryKey = 'idRuang';
	public $incrementing = false;
	protected $fillable = [	'idRuang','namaRuang','lattitude','longitude','floor'];
}
