@extends('layouts.main')

@section('title')
    PIC
@endsection

@section('contents')
<div id="page-wrapper">
 <div class="row">
 <div class="col-lg-12">
    <h1 class="page-header text-center">Data PIC</h1>
    <hr class="col-md-12">
   <a href="{{route('pic.add')}}">
    <button type="button" class="btn btn-primary" name="button" style="margin-bottom: 20px">Tambah Person In Charge</button> </a>
  </div>
  </div>

<div class="panel panel-default">
   <div class="panel-heading" style="background-color: #013880;color: white; margin-bottom: 10px;">
   <i class="fa fa-user fa-fw"></i><b>Ruang</b>
   </div>
<div class="panel-body">
<div class="table table-responsive">
<table class="table table-bordered table-striped" id="tablepic" style="width:100%">
 <thead> <tr> 
  <th>#</th><th>idPIC</th><th>Nama PIC</th><th>Keterangan</th><th>createt at</th> 
  <!-- <th>action</th> -->
 </tr> </thead>
 <tbody>
 @foreach($p as $key => $pic)
 <tr>
 <td> {{ $key+1}}</td>
 <td> {{ $pic->idPIC}}</td>
 <td> {{ $pic->namaPIC}}</td>
 <td> {{ $pic->keterangan}}</td>
 <td> {{ $pic->created_at}}</td>
 <!--
 <td> <a href="{{ url('/pic/delete/'.$pic->idPIC) }}" class="btn btn-danger">Delete</a>
 <a href="{{ url('/pic/'.$pic->idPIC.'/edit/')}}" class=" btn btn-primary">Edit</a></td>
  -->
 </tr>
 @endforeach
</tbody>
</table>
</div></div></div></div>
@endsection
