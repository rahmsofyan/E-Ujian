<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kehadiran extends Model
{
    protected $table = 'kehadiranv2';
    protected $primaryKey = 'idA';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [ 
        'id','idUser','idAgenda',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'p7',
        'p8',
        'p9',
        'p10',
        'p11',
        'p12',
        'p13',
        'p14',
        'p15',
        'p16',
        'p17',
        'p18',
        'p19',
        'p20'];
}
