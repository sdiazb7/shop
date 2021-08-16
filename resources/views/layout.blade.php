<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="favicon.ico">
        <title>Prueba tecnica</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.css" integrity="sha256-CNwnGWPO03a1kOlAsGaH5g8P3dFaqFqqGFV/1nkX5OU=" crossorigin="anonymous" />
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
	    <!-- Font size -->
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">	
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-dark border-bottom">
               <h3>Sport Shoes</h3>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
			</nav>
        </header>
        <!-- Contenido -->
        <main role="main" class="container">
            <div class="row mt-3">
                <div class="col-12">
                    @yield('content')
                </div>
                <div class="col-4">
                    <p>&nbsp;</p>
                </div>
            </div>
        </main>
	    <script type="text/javascript" src="{{ url('js/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/sweetalert.min.js') }}"></script>
        
        @if(Session::has('mensaje'))
            <script type="text/javascript">
                swal({
                    title: "Mensaje!",
                    text: "{!! Session::get('mensaje') !!}",
                    icon: "warning",
                    button: "OK",
                    dangerMode: true,
                    closeOnClickOutside: false
                });
            </script>
        @endif

        @if ($errors->any())
            <script type="text/javascript">
                var html ='';
                @foreach ($errors->all() as $error)
                    html +='{{ @$error }}\n';
                @endforeach
                swal({
                    title: "Mensaje!",
                    text: html,
                    icon: "warning",
                    button: "OK",
                    dangerMode: true,
                    closeOnClickOutside: false
                });
            </script>
        @endif

        <script type="text/javascript">
            function valideKey(evt){
                var code = (evt.which) ? evt.which : evt.keyCode;
                if(code==8) {
                    return true;
                } else if(code>=48 && code<=57) {
                    return true;
                } else{
                    return false;
                }
            }
        </script>	
    </body>
</html>
