
<table class="table table-bordered table-striped" id="tableagen" style="width:100%">
    <thead> 
        <tr> 
        <?php 
        $jmlcolumn = 3 +count($penilaian);
        $nilai = [];
        $nilai['avg'] = [];
        ?>
        
        <th>#</th>
        <th>NRP</th>
        <th>Nama</th>
            @foreach ($penilaian as $key => $column)
            <?php
            $nilai['avg'][$key] = [];
            ?>
            <td>{{$column->nama}}</td>
            @endforeach
        
        <th><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" >+ Tambah Nilai</button></th>
        </tr> 

    </thead>
   
    <tbody>
            @foreach ($daftarnilai as $keyitem => $itemnilai )
            <tr>
                <td>{{$keyitem+1}}</td>
                @foreach($itemnilai as $key =>$item)
                    <td>{{$item}}</td>
                    @if($key>1)
                    <?php 
                    array_push($nilai['avg'][$key-2],$item);
                    ?>
                    @endif
                @endforeach
            </tr>
            @endforeach
   </tbody>
   <tfoot>
       <tr>
       <td colspan="{{$jmlcolumn}}">Total</td>
       </tr>
       <tr>
            <td colspan="3">Rata - rata </td>
            @foreach ($nilai['avg'] as $item)
            <td>{{array_sum($item)/count($item)}}</td>
            @endforeach
      </tr>
      <tr>
            <td colspan="3">Minimum  </td>
            @foreach ($nilai['avg'] as $item)
            <td>{{min($item)}}</td>
            @endforeach
      </tr>

      <tr>
            <td colspan="3">Maximum  </td>
            @foreach ($nilai['avg'] as $item)
            <td>{{max($item)}}</td>
            @endforeach
      </tr>
      <?php 
        function sd_square($x, $mean) { return pow($x - $mean,2); }
        function sd($array) {
        return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
        }
      ?>
      <tr>
            <td colspan="3">Standar Deviasi  </td>
            @foreach ($nilai['avg'] as $item)
            <td>{{sd($item)}}</td>
            @endforeach
      </tr>
   </tfoot>
   </table>