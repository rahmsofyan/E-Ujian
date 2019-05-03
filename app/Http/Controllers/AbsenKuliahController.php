<?php

namespace App\Http\Controllers;

use App\absenKuliah;
use App\kehadiran;
use App\agenda;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AbsenKuliahController extends Controller
{
    
    var $k;
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

        $kehadiran = DB::table('kehadiranv2')
                    ->join('users', 'kehadiranv2.idUser', '=', 'users.idUser')
                    ->leftjoin('pic', 'kehadiranv2.idUser', '=', 'pic.idPIC')
                    ->select('kehadiranv2.*', 'users.name',)
                    ->where('kehadiranv2.idAgenda', '=', $idAgenda)
                    ->get();
//        dd($kehadiran);

        $dosen = DB::table('agenda')
                    ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
                    ->select('pic.namaPIC', 'agenda.namaAgenda','agenda.WaktuMulai','agenda.idAgenda','agenda.toleransiKeterlambatan')
                    ->where('agenda.idAgenda', '=', $idAgenda)
                    ->get()->first();
        //dd($dosen);

        $tanggals = DB::table('absenKuliah')
                    ->select('tglPertemuan')
                    ->orderBy('tglPertemuan','asc')
                    ->where('fk_idAgenda','=',$idAgenda)
                    ->get();

        // $wkwks = DB::select('exec GetData(?)',array($idAgenda));
        
        $statusKehadiran = ['izin','alpha'];
        return view('absenKuliah.tampilKehadiran', compact('kehadiran', 'dosen', 'tanggals','statusKehadiran'));
    }
    

    public function UpdateStatusKehadiran(Request $request)
    {
        kehadiran::where('idUser',$request->nrp)
                ->where('idAgenda',$request->idAgenda)
                    ->update([$request->p => $request->status]);
        return redirect()->back();
    }

    public function UpdateToleransiKehadiran(Request $request)
    {
        $tes = agenda::where('idAgenda',$request->idAgenda)
                ->update(['toleransiKeterlambatan' => $request->toleransi]);
        return redirect()->back();
    }

    public static function filterhadir($tanggal,$arraydata,$masuk,$until,$tolerance) {
        $index = 1;
        $result = [];
        foreach ($arraydata as $key => $row) {
            if($key != 'p'.$index || $index>$until)continue;
            echo '<td ';

            
            if ($row =='izin') {
                echo 'class="alert btn-primary"';
                $result['p'.$index]['izin']=1;
                
            }
            elseif ($row==null && strtotime($tanggal[$index-1]->tglPertemuan) > strtotime(date('d-M-Y'))){
                echo 'class="alert btn-light"';
                $result['p'.$index]['special']=1;
            }
            elseif ($row == null ||  $row=='alpha') {
                echo 'class="alert btn-danger"';
                $result['p'.$index]['alpha']=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 <= 0)
            {
                echo "class='alert' style='background-color:rgb(0,200,0);'";
                $result['p'.$index]['ontime']=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 >= 0  && (strtotime($row) - strtotime($masuk)) / 60 < $tolerance)
            {
                
                $perminutes = 255/$tolerance;
                $color = (strtotime($row) - strtotime($masuk)) / 60 * $perminutes;
                echo "class='alert' style='background-color:rgb($color,200,0);'";
                $result['p'.$index]['intolerance']=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 > $tolerance)
            {
                echo "class='alert' style='background-color:rgb(255,200,0);'";
                $result['p'.$index]['late']=1;
            }
            
            
            echo '></td>';
            $index +=1;
        }
        return $result;
    }

}
