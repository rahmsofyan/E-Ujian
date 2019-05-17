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
        $this->JmlPertemuan = 16;
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

        $FilterKehadiranMahasiswa = [];
        $Rekapitulasi = $this->GetRekapitulasiModel($this->JmlPertemuan);
        
        foreach ($kehadiran as $key => $row) {
            
            $FilterKehadiranMahasiswa[$key]=['nrp'=>$row->idUser];
            $FilterKehadiranMahasiswa[$key]['nama'] = $row->name;
            $FilterKehadiranMahasiswa[$key]['pertemuan'] =  $this->filterhadir($tanggals,$row,$dosen->WaktuMulai,$this->JmlPertemuan,$dosen->toleransiKeterlambatan);
            
            
            for($i = 1;$i<=$this->JmlPertemuan;$i++)
            {
                $Status = $FilterKehadiranMahasiswa[$key]['pertemuan']['kehadiran']['p'.$i]['status'];
                
                if($Status=='izin'){
                $Rekapitulasi['Tidak Hadir']['Izin']['p'.$i] += 1;
                $Rekapitulasi['Tidak Hadir']['Total']['p'.$i] +=1;
                }
                else if($Status=='special'){
                $Rekapitulasi['Tidak Hadir']['Tidak Ada Kelas']['p'.$i] += 1;
                $Rekapitulasi['Tidak Hadir']['Total']['p'.$i] +=1;
                }
                else if($Status=='alpha'){
                $Rekapitulasi['Tidak Hadir']['Alpha']['p'.$i]   += 1;
                $Rekapitulasi['Tidak Hadir']['Total']['p'.$i] +=1;
                }
                else if($Status=='ontime'){
                $Rekapitulasi['Hadir']['Tepat Waktu']['p'.$i]  += 1;
                $Rekapitulasi['Hadir']['Total']['p'.$i] +=1;
                }
                else if($Status=='intolerance'){
                $Rekapitulasi['Hadir']['Dalam Toleransi']['p'.$i] += 1;
                $Rekapitulasi['Hadir']['Total']['p'.$i] +=1;
                }
                else if($Status=='late'){
                $Rekapitulasi['Hadir']['Terlambat']['p'.$i] += 1;
                $Rekapitulasi['Hadir']['Total']['p'.$i] +=1;
                }
            }
            
        }
        #dd($Rekapitulasi);
        #dd($FilterKehadiranMahasiswa);
        
        $statusKehadiran = ['izin','alpha'];
        
        return view('myagenda.kehadiran.tampilKehadiran', compact('Rekapitulasi','kehadiran','FilterKehadiranMahasiswa', 'dosen', 'tanggals','statusKehadiran'));
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

        $maxn1 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->max('nilai1');     

        $maxn2 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->max('nilai2');

        $maxn3 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->max('nilai3');

        $maxn4 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->max('nilai4');

        $maxnr =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->max('nilai_rata');

        $minn1 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->min('nilai1');     

        $minn2 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->min('nilai2');

        $minn3 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->min('nilai3');

        $minn4 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->min('nilai4');

        $minnr =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->min('nilai_rata');
        
        $avgn1 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->avg('nilai1');     

        $avgn2 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->avg('nilai2');

        $avgn3 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->avg('nilai3');

        $avgn4 =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->avg('nilai4');

        $avgnr =  DB::table('nilaimhs')->select('*')
                    ->where('idAgenda','=',$idAgenda)
                    ->avg('nilai_rata');

        return view('myagenda.penilaian.tampilPenilaian',compact('mhs','dosen','tanggals','maxn1','maxn2','maxn3','maxn4','maxnr','minn1','minn2','minn3','minn4','minnr','avgn1','avgn2','avgn3','avgn4','avgnr'));
    }
    
    public function updateNilai( Request $request)
    {
        $nilai = nilaimhs::findOrFail($request->id);

        $nilai->nilai1 = $request->nilai1;
        $nilai->nilai2 = $request->nilai2;
        $nilai->nilai3 = $request->nilai3;
        $nilai->nilai4 = $request->nilai4;
        $jumlah = $request->nilai1 + $request->nilai2 + $request->nilai3 + $request->nilai4;
        $nilai->nilai_rata = $jumlah/4;

        $nilai->save();

        return back();
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

    public function UpdateJadwalKehadiran(Request $request)
    {
        kehadiran::where('idAgenda','=',$request->idAgenda)
                    ->update([$request->p=>'special']);
        return redirect()->back();
    }
    
    public static function GetRekapitulasiModel($JmlPertemuan){
        $Rekapitulasi = [];
        
        for($i = 1;$i<=$JmlPertemuan;$i++){
            $Rekapitulasi['Hadir']['Tepat Waktu']['p'.$i] =0;
            $Rekapitulasi['Hadir']['Dalam Toleransi']['p'.$i] =0;
            $Rekapitulasi['Hadir']['Terlambat']['p'.$i] =0;
            $Rekapitulasi['Hadir']['Total']['p'.$i] = 0;

            $Rekapitulasi['Tidak Hadir']['Izin']['p'.$i]    =0;
            $Rekapitulasi['Tidak Hadir']['Alpha']['p'.$i] =0;
            $Rekapitulasi['Tidak Hadir']['Tidak Ada Kelas']['p'.$i] =0;
            $Rekapitulasi['Tidak Hadir']['Total']['p'.$i] = 0;
        }

        return $Rekapitulasi;
    }

    public function Filterhadir($tanggal,$arraydata,$masuk,$until,$tolerance) {
        $index = 1;
        $result = [];
        
        $total = [];
        $total['izin']=0;
        $total['special']=0;
        $total['ontime']=0;
        $total['alpha']=0;
        $total['intolerance']=0;
        $total['late']=0;
        
        foreach ($arraydata as $key => $row) {
            if($index>$until)continue;
            if ($row =='izin') {
                $result['p'.$index]['status']='izin';
                $result['p'.$index]['value']=0;
                $total['izin'] +=1;
                
            }
            elseif ($row=='special' || $row==null && strtotime($tanggal[$index-1]->tglPertemuan) > strtotime(date('d-M-Y'))){
                $result['p'.$index]['status']='special';
                $result['p'.$index]['value']=0;
                $total['special'] +=1;
            }
            elseif ($row == null ||  $row=='alpha') {
                
                $result['p'.$index]['status']='alpha';
                $result['p'.$index]['value']=0;
                $total['alpha'] +=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 <= 0)
            {
                $result['p'.$index]['status']='ontime';
                $result['p'.$index]['value']=0;
                $total['ontime'] +=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 > 0  && (strtotime($row) - strtotime($masuk)) / 60 < $tolerance)
            {
                $result['p'.$index]['status']='intolerance';
                $result['p'.$index]['value']= (strtotime($row) - strtotime($masuk))/60;
                $total['intolerance'] +=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 > $tolerance)
            {
                $result['p'.$index]['status']='late';
                $result['p'.$index]['value']= (strtotime($row) - strtotime($masuk))/60;
                $result['p'.$index]['late']=1;
                $total['late'] +=1;
            }
            $index +=1;
        }
        
        return ["kehadiran"=>$result,"rekapitulasi"=>$total];
    }
}
