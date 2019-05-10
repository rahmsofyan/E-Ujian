<?php


namespace App\Http\Controllers;

use App\absenKuliah;
use App\kehadiran;
use App\agenda;
use App\penilaian;
use App\daftarnilai;
use App\nilaiMhs;
use Illuminate\Http\Request;
use PDF;
use App\user;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class agendabyPICController extends Controller
{
    var $k;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function agendabyPIC($idPIC)
    {
        if($idPIC!==null)
        {
            return $AllAgendaByPIC = agenda::where('fk_idPIC',$idPIC)->get();
        }
        else return [];
    }

    public function index()
    {

        $idPIC = \Auth::user()->getPIC()->idPIC;

        $listAgenda = DB::table('agenda')
        ->join('pic', 'agenda.fk_idPIC', '=', 'pic.idPIC')
        ->select('agenda.idAgenda', 'agenda.namaAgenda', 'pic.namaPIC')
        ->where('agenda.fk_idPIC','=',$idPIC)
        ->get();

        return view('myagenda.kehadiran.listKehadiran',compact('listAgenda'));
    }

    // menampilkan halaman untk nambah berita acara
    public function create()
    {
        $agenda = agenda::all();
        return view('myagenda.create', compact('agenda'));
    }


    public function store(Request $request)
    {

       absenKuliah::create($request->all());
       return redirect('/myagenda');
    }


    public function show(absenKuliah $absenKuliah)
    {
        //
    }

    public function edit($idAbsen)
    {
        //
        $a = absenKuliah::findorfail($idAbsen);
        return view ('myagenda.edit',compact('a'));
    }


    public function update(Request $request, $id)
    {
        //
        $a = absenKuliah::findorfail($id);
        $a->update($request->all());
        return redirect('myagenda/berita/'.$a->fk_idAgenda);

    }


    public function destroy(absenKuliah $absenKuliah)
    {
        //
        $a = absenKuliah::findorfail($id);
        $a->delete();
        return redirect('/myagenda');

    }

    public function berita($idAgenda)
    {
        //$a=absenKuliah::all()->where('absenKuliah.fk_idAgenda', '=', $idAgenda);
        $a = DB::table('absenKuliah')->where('fk_idAgenda', '=', $idAgenda)->orderBy('tglPertemuan', 'asc')->get();
        return view('myagenda.berita.index',compact('a'));
    }

    public function tampilKehadiran($idAgenda)
    {
        // $wkwks = DB::select('select * from kehadiran INNER JOIN users ON kehadiran.idUser = users.idUser where kehadiran.idAgenda = ?;', array($idAgenda));
        DB::statement('call Cek()');

        $kehadiran = DB::table('kehadiranv2')
                    ->join('users', 'kehadiranv2.idUser', '=', 'users.idUser')
                    ->leftjoin('pic', 'kehadiranv2.idUser', '=', 'pic.idPIC')
                    ->select('kehadiranv2.*', 'users.name')
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
        return view('myagenda.kehadiran.tampilKehadiran', compact('kehadiran', 'dosen', 'tanggals','statusKehadiran'));
    }

    public function detailNilai($idAgenda){
        $mhs = nilaiMhs::where('idAgenda',$idAgenda)->get();
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

        return view('myagenda.penilaian.tampilPenilaian',compact('mhs','dosen','tanggals'));
    }

    public function tampilNilai($idAgenda)
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

        $idAgenda = $dosen->idAgenda;

        $penilaian = penilaian::where('idAgenda','=',$idAgenda)
                    ->get();
        
        $dumpnilai = collect();
        foreach ($penilaian as $key => $item) {
            $dumpnilai[$key] = daftarnilai::
                                   join('users', 'daftarnilai.idUser', '=', 'users.idUser')
                                   ->where('idPenilaian','=',$item->idPenilaian)
                                   ->select('daftarnilai.idPenilaian','daftarnilai.nilai', 'users.idUser','users.name')
                                   ->get();
        }

        $daftarnilai = [];
        foreach ($kehadiran as $key => $row) {
            $daftarnilai[$key][0] = $row->idUser;
            $daftarnilai[$key][1] = $row->name;
        }

        for($j=0;isset($daftarnilai) && $j<count($daftarnilai);$j++)
            for($i=0;$i<count($penilaian);$i++){
                if(isset($dumpnilai[$i])==false)continue; 
                $daftarnilai[$j][$i+2] = $dumpnilai[$i][$j]->nilai;
            }   
        return view('myagenda.penilaian.tampilPenilaian', compact('daftarnilai', 'dosen', 'tanggals','penilaian'));
    }
    
    public function tambahpenilaian(Request $request)
    {
       
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
