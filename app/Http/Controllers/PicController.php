<?php

namespace App\Http\Controllers;

use App\pic;
use Illuminate\Http\Request;

class PicController extends Controller
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
        $p=pic::all();
        return view('pic.index',compact('p'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
	return view('pic.create');
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
       pic::create($request->all());
       return redirect('/pic');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pic  $pic
     * @return \Illuminate\Http\Response
     */
    public function show(pic $pic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pic  $pic
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $p = pic::findorfail($id);
        return view ('pic.edit',compact('p'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pic  $pic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $p = pic::findorfail($id);
        $p->update($request->all());
        return redirect('/pic');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pic  $pic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $p = pic::findorfail($id);
        $p->delete();
        return redirect('/pic');


    }
}
