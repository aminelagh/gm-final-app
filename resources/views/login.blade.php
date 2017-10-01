<!DOCTYPE html>
<html lang="en">

<head>
    <title>Authentification</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('anime/anime.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{{ asset('img/golfmaroc.png') }}}">

</head>

<body background="{{{ asset('img/golf1.jpg') }}}" background-position="center">

<div class="container">
    <div class="row">


        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>Authentification</b></h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{ route('submitLogin') }}" method="POST">
                        {{ csrf_field() }}

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control"
                                       placeholder="E-mail" name="email" type="email" value="{{ old('email') }}"
                                       autofocus required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" placeholder="Password"
                                       name="password" type="password" required>
                            </div>


                            <div class="checkbox">
                                <label><input name="remember" type="checkbox" value="Remember Me">Remember Me</label>
                            </div>
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/metisMenu.js"></script>
<script src="js/sb-admin-2.js"></script>
<script src="{{ asset('anime/bootstrap-notify.js') }}"></script>
@include('layouts.alerts_2')

</body>

</html>


