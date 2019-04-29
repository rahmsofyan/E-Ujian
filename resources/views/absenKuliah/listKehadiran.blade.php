@extends('layouts.main')

@section('title')
    Absen Kuliah
@endsection

@section('contents')
<!-- Modal -->
<div id="page-wrapper">
   <div class="row">
       <div class="col-lg-12">
          <h1 class="page-header text-center">Data Absen Kuliah</h1>
          <hr class="col-md-12">
        </div>
    </div>

    <div class="panel panel-default">
       <div class="panel-heading" style="background-color: #013880;color: white;margin-bottom: 10px;">
        <iclass="fa fa-user fa-fw"></i><b>Data Absen Kuliah</b>
       </div>
        <div class="panel-body">
	        <div class="table table-responsive">
		        <table class="table table-bordered table-striped" id="tableagen" style="width:100%">
			        <thead> 
			            <tr> 
			            <th>#</th>
			            <th>idAgenda</th>
			            <th>Nama Agenda</th>
			            <th>Dosen</th>
			           	<th colspan="2">action</th>
			            </tr> 
			        </thead>
			        <tbody>
			         @foreach($a as $key => $agenda)
			         <tr>
			         <td> {{ $key+1}}</td>
			         <td> {{ $agenda->idAgenda}}</td>
			         <td> {{ $agenda->namaAgenda}}</td>
			         <td> {{  $agenda->namaPIC}} </td>
			         <td colspan="2">
			         	<a href="{{ route('absenKuliah.tampilKehadiran', $agenda->idAgenda) }}" class=" btn btn-info" style="margin: 5px">Lihat Absensi</a>

			         	<a href="{{ route('absenKuliah.berita', $agenda->idAgenda) }}" class=" btn btn-primary" style="margin: 5px">Berita Acara</a>
			         </td>			         
			         </tr>
			         @endforeach
			        </tbody>
		        </table>
	        </div>
        </div>
      </div>
</div>
@endsection
