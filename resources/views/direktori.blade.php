@extends('layouts.main')

@section('contents')
<div class="container">
    <div class="row">
        <div class="">
            <div cla">
            <div class="panel-body">
               <div class="col-md-3 btn-success" align="center">
                <h3>Gambar : {{$jmlGambar}}</h3>
               </div>
               <div class="col-md-4 col-md-offset-1 btn-success" align="center">
                <h3>Folder : {{$jmlFolder}}</h3>
               </div>
               <div class="col-md-3 col-md-offset-1 btn-success" align="center">
                <h3>Lain-lain : {{$jmlLain}}</h3>
               </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <div class="table table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Nama File</th>
                          <th scope="col">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($array_file as $file)
                        <tr>
                            <td class="col-sm-8">{{$file['filename']}}</td>
                            @if(empty($file['extension']))
                                <td><a class="btn btn-success" href="{{ url('/directory/'.$file['filename']) }}">Folder</a>
                                </td>
                                @continue
                            @endif

                            @if($file['extension']=="jpg")
                              <td>
                                <form method="post" target="_blank" action="{{ url('/openImage')}}"/>
                                <input type="hidden" value="{{ $path.$file['basename'] }}"  name="nama_gambar"/>
                                <input class="col-sm-8 btn btn-primary" type="submit" value="Buka"/>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                </form>
                              </td>
                            @else
                              <td><span class="col-sm-8 btn btn-info">{{$file['extension']}}</span>
                            </td>
                            @endif
                        </tr>
                        @endforeach                     
                      </tbody>
                    </table>
                  </div>
                </div>

                <div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
