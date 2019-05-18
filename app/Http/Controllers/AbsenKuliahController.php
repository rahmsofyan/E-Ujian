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

        $FilterKehadiranMahasiswa = [];
        $this->JmlPertemuan = count($tanggals);
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
        
        $statusKehadiran = ['izin','alpha'];
        
        return view('absenkuliah.tampilKehadiran', compact('Rekapitulasi','kehadiran','FilterKehadiranMahasiswa', 'dosen', 'tanggals','statusKehadiran'));
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
        
}
