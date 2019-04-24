<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="{{ URL::asset('css/eujian.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/eujian.js') }}"></script>
    
    
    <!--Summer Note js-->
    <link href="{{ URL::asset('summer/summer_req_bootstrap.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('summer/summer_req_jquery.js') }}"></script>
    <script src="{{ URL::asset('summer/summer_req_bootstrap.js') }}"></script>
    <!--Summernote-->
    <link href="{{ URL::asset('summer/summernote.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('summer/summernote.min.js') }}"></script>


    
    <title>Home</title>
</head>

<body >
        {{ Form::open(array('route' => 'soal.store', 'method' => 'POST')) }}
        {{Form::text('namaSoal', 'contoh', array('class' => 'name')) }}
        {{Form::token()}}
        <textarea id="summernote" name="content"></textarea>
        
        {{Form::submit('Submit', array('class' => 'name'))}}
        {{Form::close()}}
      <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
        
      </script>
    </div>
</body>
</html>