<?php

namespace App\Http\Controllers;

use App\absenKuliah;
use App\agenda;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AbsenKuliahController extends Controller
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
        $a = DB::table('agenda')
            ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
            ->select('agenda.idAgenda', 'agenda.namaAgenda', 'pic.namaPIC')
            ->get();
        return view('absenKuliah.listKehadiran',compact('a'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // menampilkan halaman untk nambah berita acara
    public function create()
    {
        $agenda = agenda::all();
        return view('absenKuliah.create', compact('agenda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //
        // $test = $request->all();
        // dd($test);
       absenKuliah::create($request->all());
       return redirect('/absenKuliah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\absenKuliah  $absenKuliah
     * @return \Illuminate\Http\Response
     */
    public function show(absenKuliah $absenKuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\absenKuliah  $absenKuliah
     * @return \Illuminate\Http\Response
     */
    public function edit($idAbsen)
    {
        //
        $a = absenKuliah::findorfail($idAbsen);
        return view ('absenKuliah.edit',compact('a'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\absenKuliah  $absenKuliah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $a = absenKuliah::findorfail($id);
        $a->update($request->all());
        return redirect('absenKuliah/berita/'.$a->fk_idAgenda);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\absenKuliah  $absenKuliah
     * @return \Illuminate\Http\Response
     */
    public function destroy(absenKuliah $absenKuliah)
    {
        //
        $a = absenKuliah::findorfail($id);
        $a->delete();
        return redirect('/absenKuliah');

    }

    public function berita($idAgenda)
    {
        //$a=absenKuliah::all()->where('absenKuliah.fk_idAgenda', '=', $idAgenda);
        $a = DB::table('absenKuliah')->where('fk_idAgenda', '=', $idAgenda)->orderBy('tglPertemuan', 'asc')->get();
        return view('absenKuliah.index',compact('a'));
    }

    public function tampilKehadiran($idAgenda)
    {
        // $wkwks = DB::select('select * from kehadiran INNER JOIN users ON kehadiran.idUser = users.idUser where kehadiran.idAgenda = ?;', array($idAgenda));
        DB::statement('call Cek()');

        $wkwks = DB::table('kehadiran')
                    ->join('users', 'kehadiran.idUser', '=', 'users.idUser')
                    ->leftjoin('pic', 'kehadiran.idUser', '=', 'pic.idPIC')
                    ->select('kehadiran.*', 'users.name')
                    ->where('kehadiran.idAgenda', '=', $idAgenda)
                    ->get();

        $dosen = DB::table('agenda')
                    ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
                    ->select('pic.namaPIC', 'agenda.namaAgenda')
                    ->where('agenda.idAgenda', '=', $idAgenda)
                    ->get();

        $tanggals = DB::table('absenKuliah')
                    ->select('tglPertemuan')
                    ->orderBy('tglPertemuan','asc')
                    ->where('fk_idAgenda','=',$idAgenda)
                    ->get();

        // $wkwks = DB::select('exec GetData(?)',array($idAgenda));
        return view('absenKuliah.tampilKehadiran', compact('wkwks', 'dosen', 'tanggals'));
    }
}
