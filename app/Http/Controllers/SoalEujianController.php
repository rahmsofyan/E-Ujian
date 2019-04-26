<?php

namespace App\Http\Controllers;

use App\soalEujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SoalEujianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$request->session()->flush();
        dd($request->session()->all());
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
     
     
     
     $request->session()->put('soal.'.$request->namaSoal, 
     $request->content);
      
     $data = $request->session()->get('soal');
     
     
      $file = json_encode($data); 
      Storage::put('filee.json', $file);
      $url = Storage::url('fffile.json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\soalEujian  $soalEujian
     * @return \Illuminate\Http\Response
     */
    public function show(soalEujian $soalEujian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\soalEujian  $soalEujian
     * @return \Illuminate\Http\Response
     */
    public function edit(soalEujian $soalEujian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\soalEujian  $soalEujian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, soalEujian $soalEujian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\soalEujian  $soalEujian
     * @return \Illuminate\Http\Response
     */
    public function destroy(soalEujian $soalEujian)
    {
        //
    }
}
