<div class="table table-responsive">
        <table class="table table-bordered table-striped" id="tableagen" style="width:100%">
         <thead> 
            <tr> 
            <th>#</th>
            <th>NRP</th>
            <th colspan="3">Nama</th>
            <th>Pertemmuan</th>
            <th>Action</th>
            
            </tr> 
          </thead>
         <tbody>
         @foreach($kehadiran as $key => $wk)
         <tr>
           <td> {{ $key+1}}</td>
           <td> {{ $wk->idUser}}</td>
           <td colspan="3"> {{ $wk->name }}</td>
           <td></td>
           <td></td>
         </tr>
         @endforeach
        </tbody>
        </table>
      </div>