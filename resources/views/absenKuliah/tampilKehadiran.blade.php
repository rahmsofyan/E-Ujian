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
        <div class="btn-btn-group">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-interval">Set Interval</button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-status">Opsi Status</button>
          <button form="A"  class="btn btn-primary" id="print"><li class="fa fa-print"></li>Print</button>
        </div>
        
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
           <td> {!! ($wk->p1 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p1 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p1 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p2 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p2 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p2 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p3 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p3 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p3 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p4 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p4 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p4 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p5 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p5 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p5 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p6 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p6 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p6 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p7 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p7 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p7 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p8 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p8 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p8 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p9 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p9 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p9 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p10 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p10 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p10 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p11 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p11 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p11 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p12 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p12 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p12 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p13 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p13 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p13 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p14 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p14 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p14 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p15 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p15 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p15 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p16 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p16 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p16 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
           <td> {!! ($wk->p17 == 1)? '<i class="fa fa-check" style="color: #00FF00"></i>' :(($wk->p17 == 2)?'<i class="fa fa-check" style="color: red"></i>' : (($wk->p17 == 3)?'<i class="fa fa-info"></i>': '-')) !!} </td>
         </tr>
         @endforeach
        </tbody>
        </table>
              <div id="modal-interval" class="modal inmodal fade" id="detailku" tabindex="-1" role="dialog"  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3 class="modal-title">Set Interval Keterlambatan</h3>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              
                          </div>
                          <form id="set-interval" method="POST" action="#" class="form-horizontal" enctype="multipart/form-data">
                          <div class="modal-body">
                              @csrf
                              
                              <!-- <input type="text" name="toleransi" id="toleransi" placeholder="menit"> -->
                            <div class="col-7">  
                              <h5>Toleransi Keterlambatan</h5>
                              <div class="input-group">
                                <input type="text" class="form-control" placeholder="Time">
                                  <span class="input-group-btn">
                                    <div class="input-group-text"><h6>Minutes</h6></div>
                                  </span>
                              </div>
                            </div>


                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Set</button>
                          </div>
                          </form>

                      </div>
                  </div>
              </div>
              <!-- end modal -->

              <div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Opsi Status Kehadiran</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        @include('absenKuliah/formKehadiran')
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal -->

          </div>
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
