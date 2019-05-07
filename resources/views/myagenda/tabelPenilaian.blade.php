
<table class="table table-bordered table-striped" id="tableagen" style="width:100%">
    <thead> 
        <tr> 
            <th>#</th>
        <th>NRP</th>
        <th colspan="3">Nama</th>
            @for ($i =1 ;$i <$jmlPertemuan; $i++)
            @endfor
        </tr> 

    </thead>
   
    <tbody>
     <?php $total=[]; 
      for($i=1;$i<=$jmlPertemuan;$i++)
       {
         $total['p'.$i]['izin'] =0;
         $total['p'.$i]['alpha'] =0;
         $total['p'.$i]['ontime'] =0;
         $total['p'.$i]['late'] =0;
         $total['p'.$i]['intolerance'] =0;
         $total['p'.$i]['special'] =0;
       }?>
        @foreach($kehadiran as $key => $row)
        <tr>
            <td> {{ $key+1}}</td>
            <td> {{ $row->idUser}}</td>
            <td colspan="3"> {{ $row->name }}</td>
        </tr>
        @endforeach
   </tbody>

    <tr>
        <td colspan="20"></td>
    </tr>
    <tr> <td>#</td>
        <td colspan="4">Masuk</td>
        <td colspan='{{$jmlPertemuan}}'></td>
    </tr> 
    <tr><td></td><td></td>
         <td colspan="3">Tepat Waktu</td>
         <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['ontime']."</td>"?>
    </tr>
    <tr><td></td><td></td>
         <td colspan="3">Dengan Toleransi</td>
         <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['intolerance']."</td>"?>
    </tr>
    <tr><td></td><td></td>
          <td colspan="3">Terlambat</td>
          <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['late']."</td>"?>
    </tr>
    <tr> <td></td><td></td>
           <td colspan="3">Total</td>
           <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".($total['p'.$i]['late']+$total['p'.$i]['ontime']+$total['p'.$i]['intolerance'])."</td>"?>
    </tr>
    <tr><td>#</td>
         <td colspan="4">
             Tidak Masuk
        </td>
        <td colspan='{{$jmlPertemuan}}'></td>
    </tr> 
    <tr><td></td><td></td>
           <td colspan="3">Izin</td>
           <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['izin']."</td>"?>
    </tr>
     <tr><td></td><td></td>
        <td colspan="3">Alpha</td>
           <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['alpha']."</td>"?>
    </tr>
    <tr><td></td><td></td>
        <td colspan="3">Tidak ada Kelas</td>
            <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".$total['p'.$i]['special']."</td>"?>
    </tr>
    <tr><td></td><td></td>
             <td colspan="3">Total</td>
             <?php for($i=1;$i<$jmlPertemuan;$i++)echo "<td>".($total['p'.$i]['alpha']+$total['p'.$i]['izin']+$total['p'.$i]['special'])."</td>"?>
    </tr>

   </table>