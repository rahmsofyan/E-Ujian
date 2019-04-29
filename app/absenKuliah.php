<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absenKuliah extends Model
{
    //
        protected $table = 'absenKuliah';
        protected $fillable = [ 'fk_idAgenda','tglPertemuan','waktuMulai','waktuSelesai','pertemuanKe','BeritaAcara'];

}
