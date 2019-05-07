<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="margin-top:50vh;">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" action="{{route('AgendaByPIC.tambahpenilaian')}}" method="POST">
                            @csrf 
                             <div class="form-group">
                                <label class="control-label col-sm-2">Nama Penilaian</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="tglPertemuan" placeholder="Masukan nama" name="nama" value="">
                                </div>
                             </div>
                      
                             <input type="text" class="form-control" id="tglPertemuan" placeholder="Masukan nama" name="idAgenda" value="{{$dosen->idAgenda}}" hidden>
                             <div class="form-group">
                                <label class="control-label col-sm-2">Porsi</label>
                                <div class="col-sm-10">
                                  <input type="number" class="form-control" id="waktuMulai" name="waktuMulai" value="">
                                </div>
                             </div>
                      
                             <div class="form-group">        
                                <div class="col-sm-offset-2 col-sm-10">
                                  <button type="submit" class="btn btn-primary">Tambahkan</button>
                                </div>
                             </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>