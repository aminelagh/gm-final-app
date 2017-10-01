<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('anime/anime.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-toggle.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/logo_gm.png') }}">

    <script src="{{ asset('js/datatables.min.js') }}"></script>


    @yield('styles')

</head>

<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><a href="{{ route("home") }}" ><img src="{{ asset('img/logo_gm2.png') }}" width="100px" height="50px"></a></a>
        </div>

        @yield('menu_1')

        @yield('menu_2')

    </nav>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @yield('main_content')

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>
<script src="{{ asset('anime/bootstrap-notify.js') }}"></script>
<script src="{{ asset('js/bootstrap-toggle.js') }}"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
<script type="text/javascript">
    // conteneur de l'image zoom�e
    document.write('<div id="div_zoom_image" style="position:absolute; visibility:hidden; left:-286px; top:0px; z-index:1000;">');
    document.write('<img id="img_zoom_image" src="" style="position:absolute; left:5px; top:5px; z-index:2000; hight:150px; width:150px;" />');
    document.write('</div>');

    // affiche l'image au niveau du curseur
    function overImage(imgUrl) {
        document.getElementById("div_zoom_image").style.visibility = "visible";
        document.getElementById("img_zoom_image").src = imgUrl;
        document.onmousemove = moveImage;
    }

    // masque l'image
    function outImage() {
        document.getElementById("div_zoom_image").style.visibility = "hidden";
        document.getElementById("img_zoom_image").src = "";
        document.onmousemove = "";
    }

    // permet d'afficher l'image lorsque la souris bouge dans l'image
    function moveImage(event) {
        // position
        var x = event.pageX + 5;
        var y = event.pageY + 5;
        // placement
        document.getElementById("div_zoom_image").style.left = x + "px";
        document.getElementById("div_zoom_image").style.top = y + "px";
    }
</script>

@include('layouts.alerts')

@yield('scripts')
</body>

</html>
