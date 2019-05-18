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
        <a href="{{ route('AgendaByPIC') }}" class="btn btn-danger" style="margin: 0px 5px">Kembali</a>
        <div class="btn-btn-group">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-interval">Toleransi Terlambat</button>
          <button type="button" class="btn btn-second" data-toggle="modal" data-target="#modal-Tidak Ada">Kelas Tidak Ada</button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-status">Opsi Status</button>
          <a href="/laporanabsensi/{{$idAgenda}}"  target="_blank">
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
         @include('myagenda.kehadiran.tabelKehadiran')
         <!---- modal-interval-->
              <div id="modal-interval" class="modal inmodal fade" id="detailku" tabindex="-1" role="dialog"  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3 class="modal-title">Set Interval Keterlambatan</h3>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              
                          </div>
                          <form id="set-interval"  method="POST" action="/myagenda/toleransikehadiran" class="form-horizontal" enctype="multipart/form-data">
                          <div class="modal-body">
                              @csrf
                            <div class="col-7">  
                              <h5>Toleransi Keterlambatan</h5>
                              <div class="input-group">
                                <input type="hidden"  value="{{$dosen->idAgenda}}" name="idAgenda">
                                <input type="number" class="form-control" value="{{$dosen->toleransiKeterlambatan}}" name="toleransi">
                                  <span class="input-group-btn">
                                    <div class="input-group-text"><h6>Minutes</h6></div>
                                  </span>

                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                              <input type="submit" class="btn btn-primary" value="Set">
                          </div>
                          </form>

                      </div>
                  </div>
              </div>
              <!-- end modal-interval -->
              <!---- modal-Tidak Ada-->
              <div id="modal-Tidak Ada" class="modal inmodal fade" id="detailku" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Set Untuk Tidak Ada Kelas</h3>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        </div>
                      <form id="set-interval"  method="POST" action="{{route('AgendaByPIC.UpdateJadwalKehadiran')}}" class="form-horizontal" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="input-group">
                              <input type="hidden"  value="{{$dosen->idAgenda}}" name="idAgenda">
                              <select name="p">
                                @for ($i = 1; $i < $jmlPertemuan; $i++)
                              <option value="{{'p'.$i}}" {{($i==1)?"selected":""}} >Pertemuan {{$i}}</option>
                                 @endfor
                              </select>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target=".warning-set">Set</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end modal-Tidak Ada -->
            <!-- modal-warnning-Tidak Ada  -->
            <div class="modal fade warning-set inmodal " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content" style="margin-top:30vh;">
                      <div class="modal-header">
                          <h3 class="modal-title">Yakin untuk mengganti hari ke Tidak Ada?</h3>
                      </div>
                      <div class="modal-body">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" value="Set">Submit</button>
                      </div>
                      
                  </form>
                  </div>
                </div>
              </div>
            <!--end modal-warnning-Tidak Ada  -->
              <!-- end modal status -->
              <div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document" style="margin-top:70vh;">
                  <div class="modal-content" >
                    <div class="modal-header">
                      <h4 class="modal-title">Opsi Status Kehadiran</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        @include('myagenda/kehadiran/formKehadiran')                        
                    </div>
                    <div class="modal-footer">
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
