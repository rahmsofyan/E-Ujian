@extends('layouts.main')

@section('title')
    Rekap Kehadiran
@endsection

@section('contents')
<!-- Modal -->
<div id="page-wrapper">
   <div class="row">
       <div class="col-lg-12">
          <h1 class="page-header text-center">
            Data Presensi <br>
            @foreach($dosen as $dosen)
              {!! $dosen->namaAgenda !!}
          </h1>
          <hr class="col-md-12">
        </div>
    </div>


    <div class="panel panel-default">
      <div class="row">
        <a href="{{ route('absenKuliah') }}" class="btn btn-danger" style="margin: 0px 5px">Kembali</a>
        <button form="A"  class="btn btn-info" id="print"><li class="fa fa-print"></li>Print</button>
      </div>
      <br>
       <div class="panel-heading" style="background-color: #013880;color: white;">
        <i class="fa fa-user fa-fw"></i>
        <b>
          {!! $dosen->namaPIC !!}
          @endforeach
        </b>
       </div>

       <div class="row" style="margin: 10px 0px;">
        <div>
          <?php $no = 1; ?>
            @foreach($tanggals as $t)
              <strong>@P{{$no++.' '}}:</strong> {{date('d-M-Y', strtotime($t->tglPertemuan))}}
            @endforeach
        </div>
      </div>

        <div class="panel-body">
        <div class="table table-responsive">
        <table class="table table-bordered table-striped" id="tableagen" style="width:100%">
         <thead> 
            <tr> 
            <th>#</th>
            <th>NRP</th>
            <th colspan="3">Nama</th>
            <th>p1</th>
            <th>p2</th>
            <th>p3</th>
            <th>p4</th>
            <th>p5</th>
            <th>p6</th>
            <th>p7</th>
            <th>p8</th>
            <th>p9</th>
            <th>p10</th>
            <th>p11</th>
            <th>p12</th>
            <th>p13</th>
            <th>p14</th>
            <th>p15</th>
            <th>p16</th>
            <th>p17</th>
            </tr> 
          </thead>
         <tbody>
         @foreach($wkwks as $key => $wk)
         <tr>
           <td> {{ $key+1}}</td>
           <td> {{ $wk->idUser}}</td>
           <td colspan="3"> {{ $wk->name }}</td>
           <td> {!! ($wk->p1)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p2)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p3)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p4)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p5)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p6)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p7)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p8)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p9)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p10)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p11)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p12)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p13)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p14)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p15)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p16)? '<i class="fa fa-check"></i>' :'-' !!} </td>
           <td> {!! ($wk->p17)? '<i class="fa fa-check"></i>' :'-' !!} </td>
         </tr>
         @endforeach
        </tbody>
        </table>
        </div>
        </div>
      </div>
</div>
<script>
        document.getElementById("print").addEventListener("click",function(){
            var css = '@page { size: landscape; }',
            head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet){
              style.styleSheet.cssText = css;
            } else {
              style.appendChild(document.createTextNode(css));
            }

            head.appendChild(style);

            window.print();
        })
      </script>
@endsection
