<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gtc IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>@yield('title')</title>

        @include('components.css')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

    </head>
    <body>
        <div align="center">
        <h1 class="text-dark">Laporan Kehadiran </h1>
        </div>
        <div align="Left" style="margin-left:20px; margin-top:30px;">
            <table class="table table-bordered" id="tableagen" style="width:40%">  
                <tr> 
                    <th>Nama Dosen :</th>
                    <td>{{$dosen->namaPIC}}</td>
                </tr> 
                <tr> 
                    <th>Kode Kelas :</th>
                    <td>{{$dosen->idAgenda}}</td>
                </tr> 
            </table>
        </div>
            <!-- Main Container -->
            <main id="main-container">
                <div class="content content-full">
                    @yield('contents')
                </div>
            </main>

        </div>
    </body>
</html>
