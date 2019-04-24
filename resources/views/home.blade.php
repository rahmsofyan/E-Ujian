<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ URL::asset('css/eujian.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/eujian.js') }}"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{{ URL::asset('js/ext/jquery-3.3.1.min.js') }}"></script>
    
    <title>Home</title>
</head>

<body >
        <nav class="navbar navbar-expand-lg navbar-light bg-light mr-auto">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="mynavbar">
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                      <button type="button" class="btn btn-lg btn-primary" href="#">Home <span class="sr-only">(current)</span></button>
                    </li>
                    <li class="nav-item">
                            <button type="button" class="btn btn-lg btn-primary" href="#">Register<span class="sr-only">(current)</span></button>
                    </li>
                    <li class="nav-item">
                            <button type="button" class="btn btn-lg btn-primary" href="#">Login<span class="sr-only">(current)</span></button>
                    </li>
                    
                </div>
              </nav>
    <section class='welcome plane bright_bleft oa'>
            <img class="logo" src="img/logo1.png">
            <img class="logo" src="img/logo2.png">
            <img class="logo" src="img/logo3.png">
    </section>
</body>
</html>