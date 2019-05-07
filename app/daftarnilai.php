<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class daftarnilai extends Model
{
    protected $table = 'daftarnilai';
    protected $fillable = [ 'idPenilaian','idUser','nilai'];

    public function ruang()
        {
                return $this->belongsTo('App\penilaian', 'idPenilaian', 'idPenilaian');
        }
        
}
