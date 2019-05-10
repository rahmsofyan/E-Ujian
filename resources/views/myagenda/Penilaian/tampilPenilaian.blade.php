
@extends('layouts.main')

@section('title')
    Rekap Penilaian
@endsection

@section('contents')
<!-- Modal -->
<div id="page-wrapper">
   <div class="row">
       <div class="col-lg-12">
          <h1 class="page-header text-center">
            Data Penilaian <br>
              
              {!! $dosen->namaAgenda !!}
          </h1>
          <hr class="col-md-12">
        </div>
    </div>


    <div class="panel panel-default">
      <div class="row">
        <a href="{{ route('AgendaByPIC') }}" class="btn btn-danger" style="margin: 0px 5px">Kembali</a>
        <div class="btn-btn-group">
          <button form="A"  class="btn btn-primary" id="print"><li class="fa fa-print"></li>Print</button>
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
        <div class="table table-responsive">
           @include('myagenda/Penilaian/tabelNilai')
        </div>
        <div class="modal inmodal fade" id="detailku" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content" style="margin-top:30vh;">
                      <div class="modal-header">
                        <h3 class="modal-title">Update Nilai</h3>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                          
                      </div>
                      <form method="POST" action="{{ route('AgendaByPIC.updateNilai')}}" class="form-horizontal" enctype="multipart/form-data">
                      <div class="modal-body">
                          @csrf
                          @include('myagenda/penilaian/formModal')  

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-warning">Update</button>
                      </div>
                      </form>

                  </div>
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
<script>
        $(document).ready(function(){
            $('.dataTables-nilai').DataTable({
                pageLength: 40,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
            });

            $('#detailku').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                // alert($(this).data("iduser"));
                var id = button.data('id');
                var nama = button.data('nama');
                var iduser = button.data('iduser');
                var idagenda = button.data('idagenda');
                var nilai1 = button.data('nilai1');
                var nilai2 = button.data('nilai2');
                var nilai3 = button.data('nilai3');
                var nilai4 = button.data('nilai4');
                var nilai_rata = button.data('nilairata');
                
                var modal = $(this);

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #nama').val(nama);
                modal.find('.modal-body #iduser').val(iduser);
                modal.find('.modal-body #idagenda').val(idagenda);
                modal.find('.modal-body #nilai1').val(nilai1);
                modal.find('.modal-body #nilai2').val(nilai2);
                modal.find('.modal-body #nilai3').val(nilai3);
                modal.find('.modal-body #nilai4').val(nilai4);
                modal.find('.modal-body #nilai_rata').val(nilai_rata);

            });

        });

    </script>


@endsection
