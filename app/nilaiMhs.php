<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nilaiMhs extends Model
{
    protected $table = 'nilaimhs';
    protected $fillable = 
    [
		'idAgenda',
		'idUser',
		'nilai1',
		'nilai2',
		'nilai3',
		'nilai4',
		'nilai_rata',
 	];

	public function getNamaMhs(){
		return $this->belongsTo('App\User','idUser','idUser');
	} 	
}
