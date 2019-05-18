@extends('layouts.main')

@section('title')
  Update Porsi
@endsection

@section('contents')
<!-- fk_idagenda, tgl pertemuan, waktu mulai, waktu selesai, pertemuan ke, berita acara, created at, action -->

<div id="page-wrapper">
   <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header text-center">Mengatur Porsi</h1> <hr class="col-md-12">
    </div>
  </div>

    <div class="row"><a href="{{ route('AgendaByPIC') }}" class="btn btn-danger" style="margin: 0px 15px">Kembali</a>
    </div>
  <div class="panel panel-default"> 
    <div class="panel-heading" style="background-color: #013880;color: white;">
      <i class="fa fa-user fa-fw"></i><b>Atur Porsi</b>
    </div>

    <div class="panel-body border border-primary">
     <form name="UpdatePorsi" class="form-horizontal" action="{{ route('AgendaByPICController.updatePorsi',$agenda->idAgenda)}}" method="post" onsubmit="return ValidatorPortion()">
      @csrf
          <div class="form-group">
            <label class="control-label col-sm-2">Agenda</label>
            <div class="col-sm-10">
              <!-- <input type="text" class="form-control" id="fk_idAgenda" placeholder="Masukan idAgenda" name="fk_idAgenda"> -->
            <input type="text" value="{{$agenda->namaAgenda}}" class="form-control" disabled="" name="">
            </div>
          </div>

        <div class="form-group">
          <label class="control-label col-sm-2 ">Presentase : </label>
          <div class="col-sm-10"></div>
        </div>
      <div class="form-group">
        <label class="col-sm-3 control-label ">Porsi Nilai 1</label>
          <div class="col-sm-2"  id="porsi1-container">
            <input type="number" value="{{$portion->porsi1}}" class="form-control" name="porsi1" id="porsi1" >
          </div>

        <label class="col-sm-3 control-label ">Porsi Nilai 3</label>
          <div class="col-sm-2"  id="porsi3-container">
            <input type="number" value="{{$portion->porsi2}}" class="form-control" name="porsi3" id="porsi3">
          </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label ">Porsi Nilai 2</label>
          <div class="col-sm-2"  id="porsi2-container">
            <input type="number" value="{{$portion->porsi3}}" class="form-control" name="porsi2" id="porsi2">
          </div>
        
        <label class="col-sm-3 control-label ">Porsi Nilai 4</label>
          <div class="col-sm-2"  id="porsi4-container">
            <input type="number" value="{{$portion->porsi4}}" class="form-control" name="porsi4" id="porsi4">
          </div>
      </div>


      <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-10" id="porsi5-container">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>

@endsection
