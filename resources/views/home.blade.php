<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ URL::asset('css/eujian.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/ext/jquery-3.3.1.min.js') }}"></script>
    <title>Home</title>
</head>

<body>
    <section class='welcome'>

        <div class='plane bright_bleft oa' style="
            position:absolute; 
            left:2.5vw; 
            --total:calc(30vw+15vh);
            width:calc(var(--total)-15vh); 
            height:calc(var(--total)-30vw);
            ">
            <img class="logo" src="img/logo1.png">
            <img class="logo" src="img/logo2.png">
            <img class="logo" src="img/logo3.png">
        </div>    
        <div class='plane bleft' style="float: right;">
        <button class="" style="text-align:center;">Login</button>
        <button class="" style="text-align:center;">Register</button>
        </div>    
        </div>
    </section>
</body>
</html>