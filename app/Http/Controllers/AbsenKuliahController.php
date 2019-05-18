<?php

namespace App\Http\Controllers;

use App\absenKuliah;
use App\kehadiran;
use App\agenda;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AgendabyPICController;

class AbsenKuliahController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->JmlPertemuan = 16;
        $this->StatusKehadiran = [] ;
        $this->StatusKehadiran['Hadir'] = ['Tepat Waktu','Dalam Toleransi','Terlambat'];
        $this->StatusKehadiran['Tidak Hadir'] =['Alpha','Tidak Ada Kelas','Izin'];
    }

    public function index()
    {
        $a = DB::table('agenda')
            ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
            ->select('agenda.idAgenda', 'agenda.namaAgenda', 'pic.namaPIC')
            ->get();
        
        return view('absenKuliah.listKehadiran',compact('a'));
    }


    public function tampilKehadiran($idAgenda)
    {
        DB::statement('call Cek()');

        $kehadiran = DB::table('kehadiranv2')
                    ->join('users', 'kehadiranv2.idUser', '=', 'users.idUser')
                    ->leftjoin('pic', 'kehadiranv2.idUser', '=', 'pic.idPIC')
                    ->select('kehadiranv2.*', 'users.name')
                    ->where('kehadiranv2.idAgenda', '=', $idAgenda)
                    ->get();

        $dosen = DB::table('agenda')
                    ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
                    ->select('pic.namaPIC', 'agenda.namaAgenda','agenda.WaktuMulai','agenda.idAgenda','agenda.toleransiKeterlambatan')
                    ->where('agenda.idAgenda', '=', $idAgenda)
                    ->get()->first();

        $tanggals = DB::table('absenKuliah')
                    ->select('tglPertemuan')
                    ->orderBy('tglPertemuan','asc')
                    ->where('fk_idAgenda','=',$idAgenda)
                    ->get();

       
        $Rekapitulasi = AgendabyPICController::RekapitulasiKehadiran($kehadiran,$tanggals,$dosen,$this->StatusKehadiran);
        $FilterKehadiranMahasiswa = $Rekapitulasi['RekapitulasiMahasiswa'];
        $Rekapitulasi = $Rekapitulasi['RekapitulasiTotal'];

        return view('absenkuliah.tampilKehadiran', compact('Rekapitulasi','kehadiran','FilterKehadiranMahasiswa', 'dosen', 'tanggals','idAgenda'));
    }

        
}
