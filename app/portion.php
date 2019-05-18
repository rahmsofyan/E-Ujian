<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class portion extends Model
{
    protected $table = 'portion';
    protected $primaryKey = 'idPorsi';
    protected $fillable = ['idPorsi',
    'fk_idAgenda',
    'porsi1',
    'porsi2',
    'porsi3',
    'porsi4',
    'total'];

    public function agenda()
        {
                return $this->belongsTo('App\agenda', 'fk_idAgenda', 'idAgenda');
        }
}
