<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Version;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AgendabyPICController;
use PDF;


class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('download.index');
        $versions = Version::all();

        return view('download.index',compact('versions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(['rate' => 'required']);

        $post = Version::find($request->id);


        $rating = new \willvincent\Rateable\Rating;

        $rating->rating = $request->rate;

        $rating->user_id = auth()->user()->id;


        $post->ratings()->save($rating);


        return redirect()->route("download.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
    }

    public function DownloadLaporan($idAgenda)
    {   
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
        
        $StatusKehadiran = [] ;
        $StatusKehadiran['Hadir'] = ['Tepat Waktu','Dalam Toleransi','Terlambat'];
        $JmlPertemuan = count($tanggals);
        $StatusKehadiran['Tidak Hadir'] =['Alpha','Tidak Ada Kelas','Izin'];
        $Rekapitulasi = AgendabyPICController::RekapitulasiKehadiran($kehadiran,$tanggals,$dosen,$StatusKehadiran);
        $FilterKehadiranMahasiswa = $Rekapitulasi['RekapitulasiMahasiswa'];
        $Rekapitulasi = $Rekapitulasi['RekapitulasiTotal'];
        
        return view('Download.laporan', compact('Rekapitulasi','kehadiran','FilterKehadiranMahasiswa','JmlPertemuan', 'dosen', 'tanggals','StatusKehadiran'));
        
    }
}
