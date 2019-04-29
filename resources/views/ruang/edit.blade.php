@extends('layouts.main')

@section('title')
	Ruang - Edit Ruang
@endsection

@section('contents')
<div id="page-wrapper">
 <div class="row"> <div class="col-lg-12"> <h1 class="page-header">Edit Ruang</h1> <hr class="col-md-12"> </div> </div>
 <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #013880;color: white;"><i class="fa fa-user fa-fw"></i><b>Edit Ruang</b></div>
 <div class="panel-body border border-primary">
 <form class="form-horizontal" action={{url('/ruang/'.$r->idRuang)}} method="POST" >
  {{ csrf_field() }}
  <div class="form-group">
      <label class="control-label col-sm-2">KodeRuang</label>
      <div class="col-sm-10"><input type="text" class="form-control" id="idRuang" placeholder="Masukan KodeRuang" 
         	name="idRuang" value="{{$r->idRuang}}" disabled> </div>
   </div>
  <div class="form-group">
       <label class="control-label col-sm-2">Nama Ruang</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="namaRuang" placeholder="Masukan Nama Ruang" 
		name="namaRuang" value="{{$r->namaRuang}}">
        </div>
  </div>
  <div class="form-group">
       <label class="control-label col-sm-2">Lokasi Lattitude decimal(10,8)</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="lattitude" placeholder="Masukan Lattitude"
                name="lattitude" value="{{$r->lattitude}}">
        </div>
  </div>
  <div class="form-group">
       <label class="control-label col-sm-2">Lokasi Longitude decimal(11,8)</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="longitude" placeholder="Masukan Longitude"
                name="longitude" value="{{$r->longitude}}">
        </div>
  </div>
  <div class="form-group">
       <label class="control-label col-sm-2">Lokasi Lantai</label>
        <div class="col-sm-10"><input type="text" class="form-control" id="floor" placeholder="Masukan Lantai"
                name="floor" value="{{$r->floor}}">
        </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10"> <button type="submit" class="btn btn-primary">Submit</button> </div>
  </div>
 </form>
</div> </div></div>
@endsection
