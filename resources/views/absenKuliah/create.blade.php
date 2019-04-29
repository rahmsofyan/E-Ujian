@extends('layouts.main')

@section('title')
  Absensi - Menambah Data Absensi
@endsection

@section('contents')
<!-- fk_idagenda, tgl pertemuan, waktu mulai, waktu selesai, pertemuan ke, berita acara, created at, action -->
<div id="page-wrapper">
   <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header text-center">Menambah Absensi</h1> <hr class="col-md-12">
    </div>
  </div>

  <div class="panel panel-default"> 
    <div class="panel-heading" style="background-color: #013880;color: white;">
      <i class="fa fa-user fa-fw"></i><b>Tambah Absensi</b>
    </div>

    <div class="panel-body border border-primary">
     <form class="form-horizontal" action="/absenKuliah/store" method="POST">
      @csrf
       <div class="form-group">
         <label class="control-label col-sm-2">Agenda</label>
         <div class="col-sm-10">
          <!-- <input type="text" class="form-control" id="fk_idAgenda" placeholder="Masukan idAgenda" name="fk_idAgenda"> -->
          <select class="form-control" id="fk_idAgenda" placeholder="Masukan fk_idAgenda" name="fk_idAgenda">
              <option>Pilih Agenda</option>
              @foreach($agenda as $a)
              <option value="{{ $a->idAgenda }}">{{ $a->namaAgenda }}</option>
              @endforeach
            </select>
         </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">Tanggal Pertemuan</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="tglPertemuan" placeholder="Masukan tanggal" name="tglPertemuan">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">WaktuMulai</label>
          <div class="col-sm-10">
            <input type="time" class="form-control" id="waktuMulai" name="waktuMulai">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">WaktuSelesai</label>
          <div class="col-sm-10">
            <input type="time" class="form-control" id="waktuSelesai" name="waktuSelesai">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">Pertemuan Ke</label>
          <div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="fk_idPIC" placeholder="Masukan fk_idPIC" name="fk_idPIC"> -->
            <input type="number" name="pertemuanKe" class="form-control" id="pertemuanKe">
          </div>
       </div>

       <div class="form-group">
          <label class="control-label col-sm-2">Berita Acara</label>
          <div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="notule" placeholder="Masukan notule" name="notule"> -->
            <textarea class="form-control" name="BeritaAcara" id="BeritaAcara" rows="5"></textarea>
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
