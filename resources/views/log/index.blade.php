@extends('layouts.main')

@section('title')
    Log
@endsection

@section('contents')
<div id="page-wrapper">
 <div class="row">
   <div class="col-lg-12">
      <h1 class="page-header text-center">Data Log</h1>
      <hr class="col-md-12">
      <!-- <a href="{{route('log.add')}}">
        <button type="button" class="btn btn-primary" name="button" style="margin-bottom: 20px">Tambah Log</button>
      </a> -->
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #013880;color: white; margin-bottom: 10px;">
      <i class="fa fa-user fa-fw"></i><b>Log</b>
    </div>

    <div class="panel-body">

      <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="tablelog" style="width:100%">
         <thead>
            <tr>            
            <th>ID</th>
            <th>NRP</th>
            <th>ID Agenda</th>
            <th>Status</th>
            <th>Lattitude</th>
            <th>Longitude</th>
            <th>NamaFileFOTO</th>
            <th>Created At</th>
            </tr>
          </thead>

          <tbody>
           @foreach($l as $log)
           <tr>
            <td>{{ $log->idLog}}</td>
            <td>{{ $log->fk_idUser}}</td>
            <td>{{ $log->fk_idAgenda}}</td>
            <td>{{ substr($log->status,0,strpos($log->status, ','))}}</td>
            <td>{{ $log->lattitudeHP}}</td>
            <td>{{ $log->longitudeHP}} </td>
            <td>{{ str_limit($log->namaFileFOTO, 20)}} </td>
            <td>{{ $log->created_at}}</td>
           </tr>
           @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
