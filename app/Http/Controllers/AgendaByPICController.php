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
        if(is_null($idPIC = \Auth::user()->getPIC()))return abort(404);
        
        $idPIC = $idPIC = \Auth::user()->getPIC()->idPIC;
        
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
        
        $a = absenKuliah::findorfail($id);
        $a->delete();
        return redirect('/myagenda');

    }

    public function berita($idAgenda)
    {
        $this->cek_pic($idAgenda);
        //$a=absenKuliah::all()->where('absenKuliah.fk_idAgenda', '=', $idAgenda);
        $a = DB::table('absenKuliah')->where('fk_idAgenda', '=', $idAgenda)->orderBy('tglPertemuan', 'asc')->get();
        return view('myagenda.berita.index',compact('a'));
    }

    
    public function tampilKehadiran($idAgenda)
    {
        $this->cek_pic($idAgenda);
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
        $this->JmlPertemuan = count($tanggals);
        $FilterKehadiranMahasiswa = [];
        $Rekapitulasi = $this->GetRekapitulasiModel($this->JmlPertemuan);
    
        foreach ($kehadiran as $key => $row) {
            
            $FilterKehadiranMahasiswa[$key]=['nrp'=>$row->idUser];
            $FilterKehadiranMahasiswa[$key]['nama'] = $row->name;
            $FilterKehadiranMahasiswa[$key]['pertemuan'] =  $this->filterhadir($tanggals,$row,$dosen->WaktuMulai,$this->JmlPertemuan,$dosen->toleransiKeterlambatan);
            
            
            for($i = 1;$i<=$this->JmlPertemuan;$i++)
            {
                $Status = $FilterKehadiranMahasiswa[$key]['pertemuan']['kehadiran']['p'.$i]['status'];
                
                if(in_array($Status,$this->StatusKehadiran['Tidak Hadir'])){
                    $Rekapitulasi['Tidak Hadir'][$Status]['p'.$i] += 1;
                    $Rekapitulasi['Tidak Hadir']['Total']['p'.$i] +=1;
                }else{
                    $Rekapitulasi['Hadir'][$Status]['p'.$i] += 1;
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
        $this->cek_pic($idAgenda);
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
    
    public function updateNilai(Request $request)
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
    
    public function GetRekapitulasiModel($JmlPertemuan){
        $Rekapitulasi = [];
        
        for($i = 1;$i<=$JmlPertemuan;$i++){
            foreach($this->StatusKehadiran as $key => $pack){
                foreach($pack as $item){
                    $Rekapitulasi[$key][$item]['p'.$i] =0;
                }
                    $Rekapitulasi[$key]['Total']['p'.$i] =0;
            }
        }
        return $Rekapitulasi;
    }

    public function Filterhadir($tanggal,$arraydata,$masuk,$until,$tolerance) {
        $index = 1;
        $result = [];
        $color_pass = 180/($tolerance+0.1);
        $total = [];
        foreach($this->StatusKehadiran as $key => $pack){
            foreach($pack as $item){
                $total[$key][$item] =0;
            }
        }
        
        
        foreach ($arraydata as $key => $row) {
            if($index>$until)continue;

            
            if ($row =='izin') {
                $result['p'.$index]['status']='Izin';
                $result['p'.$index]['value']=0;
                $total['Tidak Hadir']['Izin'] +=1;
                
            }
            elseif ($row=='special' || $row==null && strtotime($tanggal[$index-1]->tglPertemuan) > strtotime(date('d-M-Y'))){
                $result['p'.$index]['status']='Tidak Ada Kelas';
                $result['p'.$index]['value']=0;
                $total['Tidak Hadir']['Tidak Ada Kelas'] +=1;
            }
            elseif ($row == null ||  $row=='alpha') {
                
                $result['p'.$index]['status']='Alpha';
                $result['p'.$index]['value']=0;
                $total['Tidak Hadir']['Alpha'] +=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 <= 0)
            {
                $result['p'.$index]['status']='Tepat Waktu';
                $result['p'.$index]['value']=0;
                $total['Hadir']['Tepat Waktu'] +=1;
            }
            elseif( (strtotime($row) - strtotime($masuk)) / 60 > 0  && (strtotime($row) - strtotime($masuk)) / 60 <= $tolerance)
            {
                
                $result['p'.$index]['status']='Dalam Toleransi';
                $result['p'.$index]['value']= $color_pass*(strtotime($row) - strtotime($masuk))/60;
                $total['Hadir']['Dalam Toleransi'] +=1;
            }
            elseif((strtotime($row) - strtotime($masuk)) / 60 > $tolerance)
            {
                $result['p'.$index]['status']='Terlambat';
                $result['p'.$index]['value']= (strtotime($row) - strtotime($masuk))/60;
                $result['p'.$index]['late']=1;
                $total['Hadir']['Terlambat'] +=1;
            }
            $index +=1;
        }
        
        return ["kehadiran"=>$result,"rekapitulasi"=>$total];
    }

    public function upPorsi($fk_idAgenda)
    {
        $data['portion'] = portion::where('fk_idAgenda',$fk_idAgenda)->first();
        $data['agenda'] = agenda::findorfail($fk_idAgenda);

       
        return view('myagenda.updatePortion',$data);
    }

   public function updatePorsi(Request $request, $id){
        
        $porsi = portion::where('fk_idAgenda', $id)->first();

        if($porsi){
            $porsi->porsi1 = $request->porsi1;
            $porsi->porsi2 = $request->porsi2;
            $porsi->porsi3 = $request->porsi3;
            $porsi->porsi4 = $request->porsi4;
            $porsi->total  = $porsi->porsi1+$porsi->porsi2+$porsi->porsi3+$porsi->porsi4;
            $porsi->save();
        } else{
            $total = $request->porsi1+$request->porsi2+$request->porsi3+$request->porsi4;

            $porsi = portion::create([
                'fk_idAgenda' => $id,
                'porsi1' => $request->porsi1,
                'porsi2' => $request->porsi2,
                'porsi3' => $request->porsi3,
                'porsi4' => $request->porsi4,
                'total' => $total,
            ]);
        }
     
        return redirect()->route('AgendaByPIC');

    }
    

    public function DownloadLaporan($id)
    {
        $pdf = PDF::loadView('myagenda.penilaian.tampilPenilaian',compact('mhs','dosen','tanggals','maxn1','maxn2','maxn3','maxn4','maxnr','minn1','minn2','minn3','minn4','minnr','avgn1','avgn2','avgn3','avgn4','avgnr'));
		return $pdf->download('invoice.pdf');
    }

    public function cek_pic($idAgenda)
    {
        if(is_null(\Auth::user()->getPIC())){
            return abort(404);
        }else{
            $idPIC = \Auth::user()->getPIC()->idPIC;
            $Agenda = DB::table('agenda')
                            ->where('agenda.idAgenda','=',$idAgenda)
                            ->where('agenda.fk_idPIC','=',$idPIC)->exists();
            if($Agenda)
            return;
            else
            abort(404);
        }
        
        
    }
}
