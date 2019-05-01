<?php

namespace App\Http\Controllers;

use App\absenKuliah;
use App\agenda;
use App\pic;
use App\ruang;
use Illuminate\Http\Request;

class AgendaController extends Controller
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
        //
        $a = agenda::orderBy('created_at', 'desc')->paginate(15);
        return view('agenda.index',compact('a'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pic = pic::all();
        $ruang = ruang::all();
        return view('agenda.create', compact('pic', 'ruang'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        agenda::create($request->all());
       // membuat 16 berita acara default
       for($i=0; $i< 16; $i++){
        $yuhu = 7 * $i;
        // dd($request->tanggal); "2019-01-29"
        $array = [
            "idAgenda" => $request->idAgenda,
            "tglPertemuan" => date('Y-m-d', strtotime($request->tanggal. ' + '.$yuhu.' days')),
            "waktuMulai" => $request->WaktuMulai,
            "waktuSelesai" => $request->WaktuSelesai,
            "pertemuanKe" => $i+1,
            "BeritaAcara" => "Berita Acara Default"
        ];
        
        absenKuliah::create($array);
       }

       return redirect('/agenda');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show(agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $r = agenda::findorfail($id);
        return view ('agenda.edit',compact('r'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, agenda $agenda)
    {
        //
        $a = agenda::findorfail($id);
        $a->update($request->all());
        return redirect('/agenda');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(agenda $agenda)
    {
        //
        $a = agenda::findorfail($id);
        $a->delete();
        return redirect('/agenda');
    }
	
    public function qrCode($id)
    {


    }

}
