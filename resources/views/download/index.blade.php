@extends('layouts.main')

@section('title')
    Download Aplikasi
@endsection

@section('contents')
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header text-center">Download Aplikasi</h1>
        

            <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #013880;color: white; margin-bottom: 10px;">
                <i class="fa fa-user fa-fw"></i><b>Versi Aplikasi</b>
            </div>
            <div class="panel-body">
            <div class="table table-responsive">
            <table class="table table-bordered table-striped" id="tabledownload" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Pembuat</th>
                        <th>Kekurangan</th>                           
                        <th>Kelebihan</th>
                        <th>Star</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($versions->count())
                    @foreach($versions as $post)                  
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->nama }}</td>
                                    <td>{{$post->pembuat}}</td>
                        <td>{{ $post->kekurangan }}</td>
                        <td>{{ $post->kelebihan }}</td>                          
                        <td>
                            <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $post->averageRating }}" data-size="xs" disabled="">
                        </td>
                        <td>
                        <form action="{{ route('download.store') }}" method="POST">

                                        @csrf

                                         <div class="rating">

                                            <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $post->userAverageRating }}" data-size="xs">
                                            <input type="hidden" name="id" required="" value="{{ $post->id }}">
                                            <span class="review-no"> {{DB::table('ratings')->where('rateable_id', $post->id)->count()}} reviews</span>
                                            <br/>
                                            <button class="btn btn-success">Submit Review</button>
                                        </div>
                                        </form>
                        </td>
                        <td>
                                        <a href="{{ $post->link_download }}" class="btn btn-info">Download</a>
                                        <br>
                                        <a href="{{ $post->link_video }}" class="btn btn-info" style="margin-top: 10px;">Video</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
            $("#input-id").rating();
</script>
@endsection
