@extends('layouts.mainlaporan')

@section('title')
    Laporan Kehadiran
@endsection

@section('contents')
<link href="{{ asset('css/tabelkehadiran.css') }}" rel="stylesheet">

<table class="table table-bordered table-striped table-hover " id="tableagen" style="width:100%">
    <thead> 
        <tr> 
        <th>No </th>
        <th>NRP</th>
        <th colspan="3">Nama</th>
        <th>Presentase Kehadiran</th>
        </tr> 
    </thead>
   
    <tbody>
        @foreach($FilterKehadiranMahasiswa as $key => $row)
        <tr>
          
            <td> {{ $key+1}}</td>
            <td> {{ $row['nrp']}}</td>
            <td colspan="3"> {{ $row['nama'] }}</td>
            <?php $TotalMasuk = (array_sum($row['pertemuan']['rekapitulasi']['Hadir']) + $row['pertemuan']['rekapitulasi']['Tidak Hadir']['Izin'] +  $row['pertemuan']['rekapitulasi']['Tidak Hadir']['Tidak Ada Kelas'])/$JmlPertemuan*100?>
            @if($TotalMasuk<80)
            <td align="center" class="p-3 mb-2 bg-danger text-dark"><strong>{{$TotalMasuk." %"}}</strong></td>
            @else
            <td align="center" class="p-3 mb-2 bg-success text-dark"><strong>{{$TotalMasuk." %"}}</strong></td>
            @endif

        </tr>
        @endforeach
   </tbody>
   </table>
   <script>
       window.print();
    </script>
@endsection