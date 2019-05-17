<table class="table table-bordered table-striped table-hover " id="tableagen" style="width:100%">
        <thead> 
            <tr> 
                <th>#</th>
            <th>NRP</th>
            <th colspan="3">Nama</th>
                @for ($i =1 ;$i<$jmlPertemuan; $i++)
            <th>p{{$i}}</th>
                @endfor
            </tr> 
    
        </thead>
       
        <tbody>
            @foreach($FilterKehadiranMahasiswa as $key => $row)
            <tr>
    
                <td> {{ $key+1}}</td>
                <td> {{ $row['nrp']}}</td>
                <td colspan="3"> {{ $row['nama'] }}</td>
                @foreach ($row['pertemuan']['kehadiran'] as $key2 => $pertemuan)
                    <td class="icon-kehadiran"><span 
                         @switch($pertemuan['status'])
                            @case('Izin')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class="glyphicon glyphicon-info-sign izin" 
                                @break
                            @case('Tidak Ada Kelas')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class="glyphicon glyphicon-minus tidak_ada" 
                                @break
                            @case('Tepat Waktu')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class='glyphicon glyphicon-ok ontime'
                                @break
                            @case('Alpha')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class="glyphicon glyphicon-remove alpha"
                                @break
                            @case('Dalam Toleransi')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class='glyphicon glyphicon-ok-circle intolerance'
                                @break
                            @case('Terlambat')
                                id='{{$pertemuan['status']}}' val={{$pertemuan['value']}} class='glyphicon glyphicon-exclamation-sign late'
                                @break
                            @default
                        @endswitch
                        ></span></td>
                @endforeach
            </tr>
            @endforeach
       </tbody>
    
        <tr>
            <td colspan="20"></td>
        </tr>
        @foreach ($Rekapitulasi as $statushadir => $row)
            <tr> <td>#</td>
                <td colspan="4">{{$statushadir}}</td>
                <td colspan='{{$jmlPertemuan}}'></td>
            </tr> 
            @foreach ($row as $key=>$jenis)
            <tr><td></td><td></td>
                <td colspan="3">{{$key}}</td>
                @for ($i = 1; $i < $jmlPertemuan; $i++)    
                <td>{{$jenis['p'.$i]}}</td>
                @endfor
                @endforeach
            </tr>
        <tr><td colspan='{{$jmlPertemuan}}'></td></tr>
        @endforeach
       </table>
       <script>
           $( ".intolerance" ).each(function() {
                let val = parseInt($( this ).attr('val')) +75;
                if(val>255)val=255;
                this.style.color = "rgb("+val+",200,75)";
                console.log($(this).style);
            });
        </script>