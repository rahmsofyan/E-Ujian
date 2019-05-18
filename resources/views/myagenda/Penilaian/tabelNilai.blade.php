<table class="table table-striped table-bordered table-hover dataTables-nilai" id="tableagen" >
    <thead> 
        <tr>
            <th>No</th>
            <th><div style='width: 70px;' align="center">NRP</div></th>
            <th><div style='width: 170px;'>Nama</div></th>
            <th><div style='width: 22px;'>Nilai 1</div></th>
            <th><div style='width: 22px;'>Nilai 2</div></th>
            <th><div style='width: 22px;'>Nilai 3</div></th>
            <th><div style='width: 22px;'>Nilai 4</div></th>
            <th><div style='width: 25px;'>Rata-Rata</div></th>
            <th><div style='width: 25px;'>Nilai Akhir</div></th>
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
                <td>{{ array_sum([ ($m->nilai1*($porsi->porsi1)/100),($m->nilai2*($porsi->porsi2)/100),($m->nilai3*($porsi->porsi3)/100),($m->nilai4*($porsi->porsi4)/100)]) }}</td>
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

    <tfoot>

        <tr><td>#</td>
            <td>Rekapitulasi Penilaian</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> 

        <tr align="center"><td></td><td></td>
             <td align="left">Nilai Tertinggi</td>
             <td>{{ $maxn1 }}</td>
             <td>{{ $maxn2 }}</td>
             <td>{{ $maxn3 }}</td>
             <td>{{ $maxn4 }}</td>
             <td>{{ $maxnr }}</td>    
             <td></td>
        </tr>
 
        <tr align="center"><td></td><td></td>
             <td align="left">Nilai Terendah</td>
             <td>{{ $minn1 }}</td>
             <td>{{ $minn2 }}</td>
             <td>{{ $minn3 }}</td>
             <td>{{ $minn4 }}</td>
             <td>{{ $minnr }}</td>    
             <td></td>
        </tr>
 
        <tr align="center"><td></td><td></td>
             <td align="left">Rata-rata</td>
             <td>{{ $avgn1 }}</td>
             <td>{{ $avgn2 }}</td>
             <td>{{ $avgn3 }}</td>
             <td>{{ $avgn4 }}</td>
             <td>{{ $avgnr }}</td>    
             <td></td>
        </tr>
 
    </tfoot>

</table>

