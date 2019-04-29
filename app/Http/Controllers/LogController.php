<?php

namespace App\Http\Controllers;

use App\log;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LogController extends Controller
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
        // $l = log::orderBy('created_at', 'desc')->paginate(15);
        $l = DB::table('log')->select('*')->orderBy('created_at', 'desc')->get();
        return view('log.index',compact('l'));
    }

    public function openImage(Request $request)
    {
        $path_file = $request->nama_gambar;
        $file = $path_file;
        $type = 'image/jpg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize($file));
        echo readfile($file);
        exit();
    }

    public function storage($path_file='')
    {
        $temp_path = "/var/www/html/";
        //$temp_path = "D:/MAKALAH/";

        // return "file:///D:/MAKALAH/00_File/Foto 1.jpg";

        if(empty($path_file)||$path_file==""){
            $path=$temp_path;
        }
        else{
            $path = $temp_path.$path_file."/";
        }
        if(!is_dir($path)){
            $path=$temp_path;
        }
        $porto=opendir($path);
        $dbporto=readdir($porto);
        $array_file = array();
        $i = 0;
        $jmlGambar = 0;
        $jmlFolder=0;
        $jmlLain=0;
        while($dbporto=readdir($porto))
        {
            $info = pathinfo($path.$dbporto);
            if($info['filename']!='.'&&$info['filename']!='..')
            {
                if(!empty($info['extension'])){
                    if(($info['extension']=='jpeg'||$info['extension']=='jpg'||$info['extension']=='png')){
                    $jmlGambar++;
                    }
                }else{
                    $jmlFolder++;
                }
                $array_file[$i] = $info;
                $i++;
            }
        }
        $jmlLain = count($array_file)-$jmlFolder-$jmlGambar;

        //dd($array_file);
        // dd($_SERVER['REQUEST_URI']);

       return view('direktori',compact("array_file","jmlGambar","jmlFolder","jmlLain","path"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
      return view('log.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       log::create($request->all());
       
       return redirect('/log');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(log $log)
    {
        //
        $l = log::findorfail($id);
        return view ('log.edit',compact('l'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, log $log)
    {
        //
        $l = log::findorfail($id);
        $l->update($request->all());
        return redirect('/log');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(log $log)
    {
        //
        $l = log::findorfail($id);
        $l->delete();
        return redirect('/log');
    }
}
