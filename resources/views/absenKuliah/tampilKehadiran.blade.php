@extends('layouts.main')

@section('title')
    Rekap Kehadiran
@endsection

@section('contents')
<link href="{{ asset('css/tabelkehadiran.css') }}" rel="stylesheet">
<!-- Modal -->
<div id="page-wrapper">
   <div class="row">
       <div class="col-lg-12">
          <h1 class="page-header text-center">
            Data Presensi <br>
              
              {!! $dosen->namaAgenda !!}
          </h1>
          <hr class="col-md-12">
        </div>
    </div>


    <div class="panel panel-default">
      <div class="row">
        <a href="{{ route('absenKuliah') }}" class="btn btn-danger" style="margin: 0px 5px">Kembali</a>
        <div class="btn-btn-group">
            <a href="/laporan/kehadiran/{{$idAgenda}}"  target="_blank">
              <button form="button" class="btn btn-primary" ><li class="fa fa-print"></li>Print</button>
            </a>
            <button type="button" class="btn btn-grey" data-toggle="modal" data-target="#ModalLegenda">
                Legenda
            </button>
        </div>
        
      </div>
      <br>
       <div class="panel-heading" style="background-color: #013880;color: white;">
        <i class="fa fa-user fa-fw"></i>
        <b>
          {!! $dosen->namaPIC !!}
          
        </b>
       </div>
       
       <div class="row" style="margin: 10px 0px;">
        <div>
          <?php $jmlPertemuan = 1; ?>
            @foreach($tanggals as $t)
              <strong>@P{{$jmlPertemuan++.' '}} :</strong> {{date('d-M-Y', strtotime($t->tglPertemuan))}}
            @endforeach
        </div>
      </div>
        <div class="panel-body">
            @include('layouts.legenda')
        <div class="table table-responsive">
         @include('absenKuliah.tabelKehadiran')
          </div>
          </div>
        </div>
      </div>
</div>

@endsection
