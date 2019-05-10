        <table class="table table-bordered table-striped" id="tableagen" style="width:100%">
         <thead> 
            <tr> 
            <th>#</th>
            <th>NRP</th>
            <th colspan="3">Nama</th>
            <th>Pertemuan</th>
            <th>Status</th>
            <th>Action</th>
            
            </tr> 
          </thead>
         <tbody>
         @foreach($kehadiran as $key => $row)
         <tr>
           <form action="/AgendaByPIC/statuskehadiran" method="post">
            @csrf
           <td> {{ $key+1}}</td>
           <td name='nrp'> 
             {{ $row->idUser}}
             <input type="hidden" value="{{ $row->idUser}}" readonly name="nrp">
             <input type="hidden" value="{{ $dosen->idAgenda}}" readonly name="idAgenda">
            </td>
           <td colspan="3"> {{ $row->name }}</td>
           <td> 
              <select class="custom-select" name="p">
                @for ($i = 1; $i < $jmlPertemuan; $i++)
              <option value="{{'p'.$i}}" {{($i==1)?"selected":""}} >Pertemuan {{$i}}</option>
                 @endfor
              </select>
           </td>
           <td>
              <select class="custom-select" name="status">
                @foreach($statusKehadiran as $key => $status)
              <option value="{{$status}}" {{($key==1)?"selected":""}} name="{{$status}}">{{$status}}</option>
                @endforeach
              </select>
           </td>
           <td>
              <button type="submit" value="Submit" class="btn btn-primary btn-outline-primary " type="button">Save</button>
           </td>
         </tr>
         </form>
         @endforeach
        </tbody>
        </table>