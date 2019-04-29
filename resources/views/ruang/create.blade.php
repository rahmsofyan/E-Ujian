@extends('layouts.main')

@section('title')
	Ruang - Menambah Data Ruang
@endsection

@section('contents')
<div id="page-wrapper">
   <div class="row"> <div class="col-lg-12"> <h1 class="page-header text-center">Menambah Ruang</h1> <hr class="col-md-12"> </div> </div>
   <div class="panel panel-default"> 
   	<div class="panel-heading" style="background-color: #013880;color: white;">
       	<i class="fa fa-user fa-fw"></i><b>Tambah Ruang</b>
        </div>
   <div class="panel-body border border-primary">
   <form class="form-horizontal" action="/ruang/store" method="POST" >
    @csrf
   <div class="form-group">
     <label class="control-label col-sm-2">KodeRuang(noSpasi)</label>
     <div class="col-sm-10">
      <input type="text" class="form-control" id="idRuang" placeholder="Masukan KodeRuang" name="idRuang">
     </div>
   </div>
   <div class="form-group">
      <label class="control-label col-sm-2">Nama Ruang</label>
      <div class="col-sm-10"><input type="text" class="form-control" id="namaRuang" placeholder="Masukan Nama Ruang" name="namaRuang"></div>
   </div>
   <div class="form-group">
      <label class="control-label col-sm-2">Lattitude (	max decimal(10,8)) </label>
      <div class="col-sm-10"><input type="text" class="form-control" id="lattitude" placeholder="Masukan Lattitude" name="lattitude"></div>
   </div> 

   <div class="form-group">
      <label class="control-label col-sm-2">Longitude (max decimal(11,8))</label>
      <div class="col-sm-10"><input type="text" class="form-control" id="langitude" placeholder="Masukan Longitude" name="longitude"></div>
   </div> 
   <div class="form-group">
      <label class="control-label col-sm-2">Floor</label>
      <div class="col-sm-10"><input type="text" class="form-control" id="floor" placeholder="Masukan Floor" name="floor"></div>
   </div> 



   <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-primary">Submit</button> </div>
   </div>
  </form>
  </div></div>
</div>

@endsection
