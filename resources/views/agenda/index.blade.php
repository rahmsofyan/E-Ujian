@extends('layouts.main')

@section('title')
    Agenda
@endsection

@section('contents')
<!-- Modal -->
<div id="page-wrapper">
    <div class="row">
       <div class="col-lg-12">
          <h1 class="page-header text-center">Data Agenda</h1>
          <hr class="col-md-12">
         <a href="{{route('agenda.add')}}">
          <button type="button" class="btn btn-primary" name="button" style="margin-bottom: 20px">Tambah Agenda</button> </a>
        </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading" style="background-color: #013880;color: white;margin-bottom: 10px;">
        <i class="fa fa-user fa-fw"></i><b>Agenda</b>
      </div>

      <div class="panel-body">
        <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="tableagen" style="width:100%">
          <thead> 
            <tr> 
            <th>#</th>
            <th>idAgenda</th>
            <th>Nama Agenda</th>
            <th>Tanggal</th>
            <th>Hari</th>
            <th>Ruang</th>
            <th>W-Mulai</th>
            <th>W-Selesai</th>
            <th>PIC</th>
            <th>Note</th>  
            <th>created at</th> 
            <th>qr code</th>
            <!-- <th>action</th> -->
            </tr> 
          </thead>
          <tbody>
           @foreach($a as $key => $agenda)
           <tr>
           <td> {{ $key+1}}</td>
           <td> {{ $agenda->idAgenda}}</td>
           <td> {{ $agenda->namaAgenda}}</td>
           <td> {{ $agenda->tanggal}}</td>
           <td> {{ $agenda->hari}}</td>
           <td> {{ $agenda->fk_idRuang}} </td>
           <td> {{ $agenda->WaktuMulai}} </td>
           <td> {{ $agenda->WaktuSelesai}} </td>
           <td> {{ $agenda->fk_idPIC}} </td>
           <td> {{ $agenda->notule}} </td>
           <td> {{ $agenda->created_at}}</td>
           <td>
              <!-- <div class="visible-print text-center"> -->
                  {!! 
                    QrCode::size(150)->generate($agenda->ruang->lattitude.','. $agenda->ruang->longitude .','. $agenda->idAgenda); 
                  !!}
                  <!-- Trigger the modal with a button -->
                  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
                  <p>Scan me to attendance.</p>
                  <p>{{$agenda->ruang->lattitude .','. $agenda->ruang->longitude .',' . $agenda->idAgenda}} </p>
              <!-- </div> -->
           </td>
           
          <!-- <td> 
            <a href="{{ url('/agenda/delete/'.$agenda->idAgenda) }}" class="btn btn-danger">Delete</a>
            <a href="{{ route('agenda.edit', $agenda->idAgenda) }}" class=" btn btn-primary">Edit</a>
          </td> -->
            
           
           </tr>
           @endforeach
          </tbody>
        </table>
        </div>
        </div>
      </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
