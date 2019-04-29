@extends('layouts.main')

@section('title')
    Pertemuan Kuliah
@endsection

@section('contents')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header text-center">List Berita Acara</h1>
      <hr class="col-md-12">
      <a href="{{ route('absenKuliah') }}" class="btn btn-danger">Kembali</a>
      <a href="{{route('absenKuliah.add')}}" class="btn btn-primary">Tambah Berita Acara</a>
    </div>
  </div>

<div class="panel panel-default">

  <div class="panel-heading" style="background-color: #013880;color: white; margin-bottom: 10px;">
    <!-- <i class="fa fa-user fa-fw"></i><b>Absen Kuliah</b> -->
  </div>

  <div class="panel-body">
    <div class="table table-responsive">
      <table class="table table-bordered table-striped" id="tableabsen" style="width:100%">
        <thead>
          <tr> 
            <th>#</th>
            <!-- <th>idAbsen</th> -->
            <th>id Agenda</th>
            <th>tanggal Pertemuan</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Pertemuan Ke</th>
            <th>Berita Acara</th>
            <th>created at</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
        @foreach($a as $key => $absenKuliah)
          <tr>
            <td> {{ $key+1}}</td>
            <!-- <td> {{ $absenKuliah->id}}</td> -->
            <td> {{ $absenKuliah->fk_idAgenda}}</td>
            <td> {{ $absenKuliah->tglPertemuan}}</td>
            <td> {{ $absenKuliah->waktuMulai}}</td>
            <td> {{ $absenKuliah->waktuSelesai}} </td>
            <td> {{ $absenKuliah->pertemuanKe}} </td>
            <td> {{ $absenKuliah->BeritaAcara}} </td>
            <td> {{ $absenKuliah->created_at}}</td>
            <td> <a href="{{ route('absenKuliah.edit', $absenKuliah->id) }}" class="btn btn-warning">Edit</a> </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div></div>
@endsection
