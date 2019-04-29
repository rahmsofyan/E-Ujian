@extends('layouts.main')

@section('title')
    Ruang
@endsection

@section('contents')
<div id="page-wrapper">
 <div class="row">
 <div class="col-lg-12">
    <h1 class="page-header text-center">Data Ruang</h1>
    <hr class="col-md-12">
   <a href="{{route('ruang.add')}}">
    <button type="button" class="btn btn-primary" name="button" style="margin-bottom: 20px">Tambah Ruang</button> </a>
  </div>
  </div>

<div class="panel panel-default">
   <div class="panel-heading" style="background-color: #013880;color: white;margin-bottom: 10px;">
   <i class="fa fa-user fa-fw"></i><b>Ruang</b>
   </div>
<div class="panel-body">
<div class="table table-responsive">
<table class="table table-bordered table-striped" id="tableruang" style="width:100%">
 <thead> <tr> 
  <th>#</th><th>KodeRuang</th><th>Nama Ruang</th><th>lattitude</th><th>Longitude</th><th>Floor</th><th>createt at</th> 
  <!-- <th>action</th> -->
 </tr> </thead>
 <tbody>
 @foreach($r as $key => $ruang)
 <tr>
 <td> {{ $key+1}}</td>
 <td> {{ $ruang->idRuang}}</td>
 <td> {{ $ruang->namaRuang}}</td>
 <td> {{ $ruang->lattitude}}</td>
 <td> {{ $ruang->longitude}}</td>
 <td> {{ $ruang->floor}} </td>
 <td> {{ $ruang->created_at}}</td>
<!--
 <td> <a href="{{ url('/ruang/delete/'.$ruang->idRuang) }}" class="btn btn-danger">Delete</a>
 <a href="{{ url('/ruang/'.$ruang->idRuang.'/edit/')}}" class=" btn btn-primary">Edit</a></td>
-->
 </tr>
 @endforeach
</tbody>
</table>
</div></div></div></div>
@endsection
