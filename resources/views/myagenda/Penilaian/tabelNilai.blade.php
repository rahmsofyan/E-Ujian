<table class="table table-striped table-bordered table-hover dataTables-nilai" id="tableagen" >
    <thead> 
        <tr>
            <th>No</th>
            <th><div style='width: 70px;' align="center">NRP</div></th>
            <th><div style='width: 170px;'>Nama</div></th>
            <th><div style='width: 22px;'>N 1</div></th>
            <th><div style='width: 22px;'>N 2</div></th>
            <th><div style='width: 22px;'>N 3</div></th>
            <th><div style='width: 22px;'>N 4</div></th>
            <th><div style='width: 25px;'>N R</div></th>
            <th>Action</th>
        </tr> 
    </thead>
    <tbody>
        
             @php
                $i=1;
                @endphp
            @foreach($mhs as $m)
            <tr align="center">
                <td>{{ $i }}</td>
                <td>{{ $m->idUser }}</td>
                <td align="left">{{ $m->getNamaMhs->name }}</td>
                <td>{{ (($m->nilai1) ? $m->nilai1 : '-') }}</td>
                <td>{{ (($m->nilai2) ? $m->nilai2 : '-') }}</td>
                <td>{{ (($m->nilai3) ? $m->nilai3 : '-') }}</td>
                <td>{{ (($m->nilai4) ? $m->nilai4 : '-') }}</td>
                <td>{{ (($m->nilai_rata) ? $m->nilai_rata : '-') }}</td>
                <td><center>
                    <button class="btn btn-primary btn-sm modal-trigger tooltipped waves-effect modalclick"
                    data-id = "{{ $m->id}}"
                    data-iduser = "{{ $m->idUser}}"
                    data-idagenda = "{{ $m->idAgenda}}"
                    data-nama = "{{ $m->getNamaMhs->name }}"
                    data-nilai1 = "{{ $m->nilai1 }}"
                    data-nilai2= "{{ $m->nilai2 }}"
                    data-nilai3 = "{{ $m->nilai3 }}"
                    data-nilai4= "{{ $m->nilai4 }}"
                    data-nilairata= "{{ $m->nilai_rata }}"
                    data-toggle="modal" data-target="#detailku"><i class="fa fa-info"> Edit</i></button>
                </center>
                </td>
                @php
                    $i++;
                    @endphp
            </tr>
            @endforeach
        
    </tbody>
    
</table>

