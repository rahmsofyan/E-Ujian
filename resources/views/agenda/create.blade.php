@extends('layouts.main')

@section('title')
	Agenda - Menambah Data Agenda
@endsection

@section('contents')
<div id="page-wrapper">
   <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header text-center">Menambah Agenda</h1> <hr class="col-md-12">
    </div>
  </div>

  <div class="panel panel-default"> 
    <div class="panel-heading" style="background-color: #013880;color: white;">
     	<i class="fa fa-user fa-fw"></i><b>Tambah Agenda</b>
    </div>

    <div class="panel-body border border-primary">
     <form class="form-horizontal" action="/agenda/store" method="POST">
      @csrf
       <div class="form-group">
         <label class="control-label col-sm-2">idAgenda(noSpasi)</label>
         <div class="col-sm-10">
          <input type="text" class="form-control" id="idAgenda" placeholder="Masukan idAgenda" name="idAgenda">
         </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">Nama Agenda</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="namaAgenda" placeholder="Masukan Nama Agenda" name="namaAgenda">
          </div>
       </div>

       <div class="form-group">
        <label class="control-label col-sm-2">Singkatan Agenda</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="singkatAgenda" placeholder="Masukan Singkatan Agenda" name="singkatAgenda">
        </div>
     </div>

       <div class="form-group">
          <label class="control-label col-sm-2">tanggal</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="tanggal" placeholder="Masukan tanggal" name="tanggal">
          </div>
       </div> 

       <div class="form-group">
          <label class="control-label col-sm-2">hari</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="langitude" placeholder="Masukan hari" name="hari">
          </div>
       </div> 

       <div class="form-group">
          <label class="control-label col-sm-2">Toleransi</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="toleransi" placeholder="15" name="toleransiKeterlambatan">
          </div>
       </div> 

       <div class="form-group">
          <label class="control-label col-sm-2">fk_idRuang</label>
          <div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="fk_idRuang" placeholder="Masukan fk_idRuang" name="fk_idRuang"> -->
            <select class="form-control" id="fk_idRuang" placeholder="Masukan fk_idRuang" name="fk_idRuang">
              <option>Pilih Ruang</option>
              @foreach($ruang as $r)
              <option value="{{ $r->idRuang }}">{{ $r->idRuang }}</option>
              @endforeach
            </select>
          </div>
       </div> 

       <div class="form-group">
          <label class="control-label col-sm-2">WaktuMulai</label>
          <div class="col-sm-10">
            <input type="time" class="form-control" id="WaktuMulai" placeholder="Masukan Waktu Mulai" name="WaktuMulai">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">WaktuSelesai</label>
          <div class="col-sm-10">
            <input type="time" class="form-control" id="WaktuSelesai" placeholder="Masukan WaktuSelesai" name="WaktuSelesai">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">fk_idPIC</label>
          <div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="fk_idPIC" placeholder="Masukan fk_idPIC" name="fk_idPIC"> -->
            <select class="form-control" id="fk_idPIC" placeholder="Masukan fk_idPIC" name="fk_idPIC">
              <option>Pilih PIC</option>
              @foreach($pic as $p)
              <option value="{{ $p->idPIC }}">{{ $p->namaPIC }}</option>
              @endforeach
            </select> 
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">notule</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="notule" placeholder="Masukan notule" name="notule">
          </div>
       </div>

       <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
       </div>

      </form>
    </div>
  </div>
</div>

@endsection
